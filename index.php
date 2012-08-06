<!DOCTYPE html>
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
		<dl>
			<dt>Package</dt>
				<dd>Gold (1024MB RAM)</dd>
			<dt>Price</dt>
				<dd>$20 / month</dd>
			<dt>Recommended player limit</dt>
				<dd>45 - 60</dd>
			<dt>Server address</dt>
				<dd>crapcraft.stuzzhosting.com</dd>
		</dl>

		<h2>Live stats</h2>
		<dl id="live-stats">
			<dt>Players (3 / <a href="change-player-cap">20</a>)</dt>
				<dd>Notch<br>jeb_<br>Xxspawnkiller69xx</dd>
			<dt>Ticks per second (20 is normal)</dt>
				<dd><?php echo mt_rand( 19000, 20000 ) / 1000; ?></dd>
		</dl>

		<div id="guages"></div>
		<script async>
			google.setOnLoadCallback(function() {
				var data = google.visualization.arrayToDataTable([
					['Label', 'Value'],
					['Memory', 43],
					['CPU', 189]
				]);
				var options = {
					width: 250, height: 120,
					redFrom: 90, redTo: 100,
					yellowFrom: 75, yellowTo: 90,
					minorTicks: 4
				};

			 	var chart = new google.visualization.Gauge(document.querySelector('#guages'));
				chart.draw(data, options);
			});
		</script>
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
