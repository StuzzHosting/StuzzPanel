<?php

header( 'Cache-Control: private, max-age=0' );
header( 'Pragma: no-cache, must-revalidate' );

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
	</ul>
</div>

<div class="span8">
<div class="tab-content">


	<div class="tab-pane active" id="general">
		<h1>CrapCraft</h1>
		<div class="row-fluid">
			<div class="span5">
				<h2>Hosting</h2>
				<dl>
					<dt>Package</dt>
						<dd>Gold (<?php echo $server['max_mem']; ?>MB RAM)</dd>
					<dt>Price</dt>
						<dd>$20 / month</dd>
					<dt>Recommended player limit</dt>
						<dd>45 - 60</dd>
					<dt>Server address</dt>
						<dd>crapcraft.stuzzhosting.com</dd>
				</dl>
			</div>

			<div class="span5">
				<h2>Live stats</h2>
				<dl id="live-stats">
					<dt>Players (3 / <a href="change-player-cap"><?php echo $server['max_players']; ?></a>)</dt>
						<dd><?php echo implode( '<br>', $server['online_players'] ); ?></dd>
				</dl>
			</div>

			<div class="span2">
				<h2>Fake data</h2>
				<div id="gauge-cpu"></div>
				<div id="gauge-mem"></div>
				<div id="gauge-tick"></div>
			</div>
		</div>

		<script async src="panel.js"></script>
	</div>


	<div class="tab-pane" id="server-log">
		<pre class="server-log"><?php

foreach ( file( 'server.log' ) as $log ) {
	$log = htmlspecialchars( rtrim( $log ) );
	if ( preg_match( '/^\tat |^\S+Exception$/', $log ) ) {
		$log = '<span class="error">' . $log . '</span>';
	} elseif ( preg_match( '/^\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d \[([A-Z]+)\]/', $log, $level ) ) {
		$log = '<span class="' . strtolower( $level[1] ) . '">' . $log . '</span>';
	}
	echo $log, "\n";
}

		?></pre>
		<script async>(function(s){s.scrollTop=s.scrollHeight})(document.querySelector('.server-log'))</script>
	</div>


</div>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script async src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
