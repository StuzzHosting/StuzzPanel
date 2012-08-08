<?php

header( 'Cache-Control: private, max-age=0' );
header( 'Pragma: no-cache, must-revalidate' );

define( 'STUZZPANEL', 'BESTPANEL' );

$server = array(
	'max_players' => 20,
	'online_players' => array( 'Notch', 'jeb_', 'Xxspawnkiller69xX' ),
	'cpu' => mt_rand( 30, 140 ),
	'mem' => mt_rand( 10, 70 ) * 10.24,
	'max_mem' => 1024,
	'tick' => mt_rand( 17000, 20000 ) / 1000,
);

if ( !empty( $_GET['api'] ) ) {
	switch ( $_GET['api'] ) {
	case 'players':
		exit( json_encode( array(
			'max' => $server['max_players'],
			'list' => $server['online_players']
		) ) );
	case 'load':
		exit( json_encode( array(
			'cpu' => $server['cpu'],
			'mem' => $server['mem'],
			'maxmem' => $server['max_mem'],
			'tick' => $server['tick']
		) ) );
	}
}

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>StuzzPanel</title>
	<link href="/bootstrap/css/bootstrap.combined.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
	<script type='text/javascript'>google.load('visualization','1',{packages:['gauge']})</script>
</head>
<body>
<img src="http://www.stuzzhosting.com/img/blocks/gold.png" class="watermark">
<div class="container">
<div class="row tabbable tabs-left">
<div class="span4">
	<img src="http://panel.stuzzhosting.com/img/stuzzpanel.gif">

	<br> <br> <!-- spacer -->

	<ul class="nav nav-pills nav-stacked">
		<li class="active"><a href="#general" data-toggle="tab">General information</a></li>
		<li><a href="#server-log" data-toggle="tab">Server log</a></li>
		<li><a href="#control-room" data-toggle="tab">Control room</a></li>
	</ul>
</div>

<div class="span8">
		<h1>CrapCraft</h1>
<div class="tab-content">

	<div class="tab-pane active" id="general">
<?php require_once 'general.php'; ?>
	</div>


	<div class="tab-pane" id="server-log">
<?php require_once 'server-log.php'; ?>
	</div>


	<div class="tab-pane" id="control-room">
<?php require_once 'control-room.php'; ?>
	</div>


</div>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script async src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
