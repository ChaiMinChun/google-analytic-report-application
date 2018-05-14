<html lang="en">
<head>
<title>title</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?php
	// index 0 indicate the first date range which represent current month this is case
	$usersRate = (($data[0]['users']-$data[1]['users'])/$data[1]['users'])*100;
	$sessionRate = (($data[0]['sessions']-$data[1]['sessions'])/$data[1]['sessions'])*100; 
	$bounce = (($data[0]['bounceRate']-$data[1]['bounceRate'])/$data[1]['bounceRate'])*100; 
	$avgSessionDurationRate = (($data[0]['avgSessionDuration']-$data[1]['avgSessionDuration'])/$data[1]['avgSessionDuration'])*100; 
?>
	<p>Current month {{$month}} </p>
	<p>Title :{{$title}}</p>
	<p>Domain :{{$domain}}</p>
	<p>Users : {{$data[0]['users']}}</p>
	<p>This month compare to previous month: {{ number_format($usersRate, 2)}}</p>
	<br>
	<p>Sessions : {{$data[0]['sessions']}}</p>
	<p>This month compare to previous month: {{ number_format($sessionRate, 2)}}</p>
	<br>
	<p>BounceRate : {{ number_format($data[0]['bounceRate'], 2)}}</p>
	<p>This month compare to previous month: {{ number_format($bounce, 2)}}</p>
	<br>
	<p>Average session duration : {{ number_format($data[0]['avgSessionDuration'], 2)}}</p>
	<p>This month compare to previous month : {{ number_format($avgSessionDurationRate, 2)}}</p>
</body>
</html>
