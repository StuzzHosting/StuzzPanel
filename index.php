<?php

// This script assumes the MySQL server is in the same timezone as the web server.
date_default_timezone_set( @date_default_timezone_get() );

header( 'Cache-Control: private, max-age=0' );
header( 'Pragma: no-cache, must-revalidate' );
header( 'Expires: 01 Jan 1970 00:00:00 GMT' );

define( 'STUZZPANEL', 'BESTPANEL' );

if ( !empty( $_GET['api'] ) && $_GET['api'] == 'username' ) {
	define( 'SKIP_AUTHENTICATION', true );
	require_once 'database.php';

	// TODO: more security stuff
	if ( $u = single_query( 'SELECT `username` FROM `accounts` WHERE `key` = ?', $_GET['k'] ) ) {
		exit( $u );
	}

	exit;
}

require_once 'database.php';

$serverdata = multi_query( 'SELECT `data`, `timestamp` FROM `mc_server_stats` WHERE `username` = ? ORDER BY `timestamp` DESC LIMIT 1', USERNAME );
$server = unserialize( $serverdata['data'] );
$server['last_ping'] = strtotime( $serverdata['timestamp'] );

$session_key = sha1( SERVER_KEY . (int) ( time() / 3600 ) );

$key_valid = false;
if ( !empty( $_GET['key'] ) ) {
	$key_valid = $session_key == $_GET['key'] ||
		sha1( SERVER_KEY . (int) ( time() / 3600 - 1 ) ) == $_GET['key'];
}

if ( !empty( $_GET['api'] ) ) {
	if ( !$key_valid ) {
		header( 'Status: 403', true, 403 );
		exit;
	}

	switch ( $_GET['api'] ) {
	case 'stats':
		header( 'Content-Type: application/json' );

		exit( json_encode( array(
			'online' => $server['last_ping'] > time() - 15,
			'max'    => (int) $server['max_players'],
			'list'   => (array) $server['online_players'],
			'cpu'    => round( $server['cpu'], 1 ),
			'mem'    => round( $server['mem'], 2 ),
			'maxmem' => round( $server['max_mem'], 2 ),
			'tick'   => round( $server['tick'], 3 ),
			'chunk'  => (array) $server['chunks'],
			'ent'    => (array) $server['entities']
		) ) );
	case 'log':
		header( 'Content-Type: application/javascript' );
		
		require_once 'server-log-ajax.php';

		exit;
	case 'graph':
		header( 'Content-Type: application/json' );

		require_once 'graph-ajax.php';

		exit;
	case 'start':
		if ( $server['last_ping'] > time() - 15 ) {
			exit;
		}

		exec( 'ssh -i ~/.ssh/panel_rsa ' . USERNAME . '@' . NODE . ' -t "cd ~' . USERNAME . '/minecraft; ls -l /var/run/screen/S-' . USERNAME . '/*.minecraft || screen -dmS minecraft -t bukkit -U java -Xmx' . MAX_MEMORY . 'M -Xms256M -Xmn150m -XX:+UseConcMarkSweepGC -XX:+CMSIncrementalMode -XX:+CMSIncrementalPacing -XX:CMSIncrementalDutyCycleMin=10 -XX:CMSIncrementalDutyCycle=50 -XX:+CMSClassUnloadingEnabled -XX:ParallelGCThreads=4 -XX:+UseParNewGC -XX:MaxGCPauseMillis=50 -XX:GCTimeRatio=10 -XX:+DisableExplicitGC -jar ' . USERNAME . '.jar nogui"' );
		exit;

	case 'send':
		exec( 'ssh -i ~/.ssh/panel_rsa ' . USERNAME . '@' . NODE . ' -t "screen -S minecraft -p bukkit -X stuff ' . escapeshellarg( $_GET['cmd'] . "\n" ) . '"' );
		exit;
	}
}

$packages = array(
	256	=> array( 'name' => 'Bedrock',    	'minplayers' => 5,	'maxplayers' => 8	),
	337	=> array( 'name' => 'Unobtainium',	'minplayers' => -1<<31,	'maxplayers' => 'NaN'	),
	512	=> array( 'name' => 'Stone',      	'minplayers' => 15,	'maxplayers' => 30	),
	768	=> array( 'name' => 'Brick',      	'minplayers' => 30,	'maxplayers' => 45	),
	1024	=> array( 'name' => 'Gold',       	'minplayers' => 45,	'maxplayers' => 60	),
	1536	=> array( 'name' => 'Iron',       	'minplayers' => 60,	'maxplayers' => 90	),
	2048	=> array( 'name' => 'Diamond',    	'minplayers' => 90,	'maxplayers' => 120	),
);

$package = $packages[MAX_MEMORY];

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $serverinfo['name']; ?> | StuzzPanel</title>
	<link href="/bootstrap/css/bootstrap.combined.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
	<script type='text/javascript'>google.load('visualization','1',{packages:['annotatedtimeline','gauge']})</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</head>
<body>
<img src="http://www.stuzzhosting.com/img/blocks/<?php echo strtolower( $package['name'] ); ?>.png" class="watermark">
<div class="container">
<div class="row tabbable tabs-left">
<div class="span4">
	<img src="http://panel.stuzzhosting.com/img/stuzzpanel.gif">

	<br> <br> <!-- spacer -->

	<ul class="nav nav-pills nav-stacked">
		<li class="active"><a href="#general" data-toggle="tab">General information</a></li>
		<li><a href="#server-log" data-toggle="tab" onclick="setTimeout(function(s){s.scrollTop=1e20},0,document.querySelector('.server-log'))">Server console</a></li>
		<li><a href="#control-room" data-toggle="tab">Control room</a></li>
		<li><a href="#graph" data-toggle="tab">Graphs</a></li>
	</ul>
</div>

<noscript><style>
#server-log {
	display: block;
}
</style></noscript>

<div class="span8">
		<h1><?php echo $serverinfo['name']; ?> <span class="label offline<?php if ( $server['last_ping'] > time() - 15 ) echo ' hidden'; ?>">Offline</span></h1>
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


	<div class="tab-pane" id="graph">
<?php require_once 'graph.php'; ?>
	</div>

</div>
</div>
</div>
</div>
<script async src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
