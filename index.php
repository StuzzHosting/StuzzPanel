<?php

header( 'Cache-Control: private, max-age=0' );
header( 'Pragma: no-cache, must-revalidate' );
header( 'Expires: 01 Jan 1970 00:00:00 GMT' );

define( 'STUZZPANEL', 'BESTPANEL' );

$server = unserialize( file_get_contents( 'server.dat' ) );

if ( !empty( $_GET['api'] ) ) {
	switch ( $_GET['api'] ) {
	case 'stats':
		header( 'Content-Type: application/json' );

		exit( json_encode( array(
			'online' => $server['last_ping'] > time() - 5,
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
<img src="http://www.stuzzhosting.com/img/blocks/stone.png" class="watermark">
<div class="container">
<div class="row tabbable tabs-left">
<div class="span4">
	<img src="http://panel.stuzzhosting.com/img/stuzzpanel.gif">

	<br> <br> <!-- spacer -->

	<ul class="nav nav-pills nav-stacked">
		<li class="active"><a href="#general" data-toggle="tab">General information</a></li>
		<li><a href="#server-log" data-toggle="tab" onclick="setTimeout(function(s){s.scrollTop=1e20},0,document.querySelector('.server-log'))">Server log</a></li>
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
