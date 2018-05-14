<?php 
return [
	
	'domain'=> 'www.dev.com', // web domain name
	'application'=> 'TITLE OF WEBSITE',

    /**
	 * EMAIL configuration
	 */
	'title'=> 'EMAIL_TITLE', // this will used as prefix of the email title
	'host'=>'smtp.mailtrap.io', // email host
	'port'=>'2525', // email port
	'from' => [
        'address' => 'admin@example.com',
        'name' => 'admin',
    ],
    'receivers'=> [
    	['name'=> 'john', 'address'=> 'john@local.com'],
    	['name'=> 'foo', 'address'=> 'foo@local.com']
    ],

    'username' => '', // email username
    'password' => '', // email password

    /**
	 * https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php
	 *
	 * this configuration can be found in your "service-account-credentials.json"
	 */
	'name'=> 'Application',
	
    'key_file'=>[
        "type"=> "",
        "project_id"=> "",
        "private_key_id"=> "",
        "private_key"=> "",
        "client_email"=> "",
        "client_id"=> "",
        "auth_uri"=> "",
        "token_uri"=> "",
        "auth_provider_x509_cert_url"=> "",
        "client_x509_cert_url"=> ""
    ],

     /**
     * to get the view_id
     * https://ga-dev-tools.appspot.com/account-explorer/
     */
    'view_id'=> ""
    
];