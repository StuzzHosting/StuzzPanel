<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>StuzzPanel</title>
	<link href="/bootstrap/css/bootstrap.combined.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
</head>
<body>
<img src="http://www.stuzzhosting.com/img/blocks/gold.png" class="watermark">
<div class="container">
<div class="row">
<div class="span4">
	<img src="http://panel.stuzzhosting.com/img/stuzzpanel.gif">
</div>
<div class="span8">
	<div class="row">
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
</body>
</html>
