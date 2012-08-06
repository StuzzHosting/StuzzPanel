<?php if ( !defined( 'STUZZPANEL' ) ) exit; ?>
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
		<script async>(function(s){s.scrollTop=1e20})(document.querySelector('.server-log'))</script>
