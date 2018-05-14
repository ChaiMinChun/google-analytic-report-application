<?php
require_once __DIR__ . '/vendor/autoload.php';

use Tx\Mailer;
use Carbon\Carbon;
use Jenssegers\Blade\Blade;

$blade = new Blade('views', 'cache');
$config = require_once __DIR__.'/config.php';

$email = (new Mailer())
    ->setServer($config['host'], $config['port'])
    ->setAuth($config['username'], $config['password'])
    ->setFrom($config['from']['name'], $config['from']['address']);

if($config['receivers']) {
	foreach ($config['receivers'] as $value) {
		$email->addTo($value['name'], $value['address']);
	}
}else {
	die('No receivers!');
}

$email->setSubject($config['title'])
    	->setBody(
    		$blade->make('analytics',[
	    			'data'=>getResult(getUsersPerMonthComparision($config)->reports), 
	    			'month'=> Carbon::now()->format('M'),
	    			'title'=> $config['application'],
	    			'domain'=> $config['domain']
    			]
    		)
    	)
    	->send();
	
function getUsersPerMonthComparision($config)
{

	$VIEW_ID = $config['view_id'];
	$APPLICATION_NAME = $config['name'];

    $client = new Google_Client();
    $client->setApplicationName($APPLICATION_NAME);

    // this configuration can be found in your "service-account-credentials.json
    $client->setAuthConfig($config['key_file']);
    $client->setScopes([Google_Service_AnalyticsReporting::ANALYTICS_READONLY]);

    $gsa = new Google_Service_AnalyticsReporting($client);

    $sessions = new Google_Service_AnalyticsReporting_Metric();
	$sessions->setExpression("ga:sessions");
	$sessions->setAlias("sessions");

	$users = new Google_Service_AnalyticsReporting_Metric();
	$users->setExpression("ga:users");
	$users->setAlias("users");

	$bounceRate = new Google_Service_AnalyticsReporting_Metric();
	$bounceRate->setExpression("ga:bounceRate");
	$bounceRate->setAlias("bounceRate");

	$avgSessionDuration = new Google_Service_AnalyticsReporting_Metric();
	$avgSessionDuration->setExpression("ga:avgSessionDuration");
	$avgSessionDuration->setAlias("avgSessionDuration");

    $thisMonth = new Google_Service_AnalyticsReporting_DateRange();
    $lastMonth = new Google_Service_AnalyticsReporting_DateRange();
    $request = new Google_Service_AnalyticsReporting_ReportRequest();

    $startLastMonth  = (new Carbon('first day of last month'))->toDateString();
    $endLastMonth = (new Carbon('last day of last month'))->toDateString();

    $startThisMonth = (new Carbon('first day of this month'))->toDateString();
    $endThisMonth = (new Carbon('last day of this month'))->toDateString();

    $thisMonth->setStartDate($startThisMonth);
    $thisMonth->setEndDate($endThisMonth);

    $lastMonth->setStartDate($startLastMonth);
    $lastMonth->setEndDate($endLastMonth);

    $request->setViewId($VIEW_ID);
    $request->setDateRanges([$thisMonth, $lastMonth]);
    $request->setMetrics([$sessions, $users, $bounceRate, $avgSessionDuration]);

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests( array( $request) );

    return $gsa->reports->batchGet( $body );
}

/**
 *
 * Extract data from reports collection
 * @param  [type] $reports [description]
 * @return [array]
 *
 * Two set of data from different date ranges
 * [
 * 	[
 * 		'sessions'=> "VALUE",
 * 		'bounceRate'=> "VALUE",
 * 		'avgSessionDuration'=> "VALUE", 
 * 		'users'=> "VALUE"
 * 	],
 * 	[
 * 		'sessions'=> "VALUE",
 * 		'bounceRate'=> "VALUE",
 * 		'avgSessionDuration'=> "VALUE", 
 * 		'users'=> "VALUE"
 * 	]
 * ]
 *
 * modified from https://developers.google.com/analytics/devguides/reporting/core/v4/samples
 */
function getResult($reports) {
	$completeData = [];
    for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
        $report = $reports[ $reportIndex ];
        $header = $report->getColumnHeader();
        $dimensionHeaders = $header->getDimensions();
        $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
        $rows = $report->getData()->getRows();

        for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
            $row = $rows[ $rowIndex ];
            $dimensions = $row->getDimensions();
            $metrics = $row->getMetrics();
            for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
            }

            for ($j = 0; $j < count($metrics); $j++) {
        		$data = [];
                $values = $metrics[$j]->getValues();
                for ($k = 0; $k < count($values); $k++) {
                    $entry = $metricHeaders[$k];
                    print($entry->getName() . ": " . $values[$k] . "\n");
                    $data[$entry->getName() ] = $values[$k];
                }
	            $completeData[] = $data;
            }
        }
    }


    return $completeData;
 }
