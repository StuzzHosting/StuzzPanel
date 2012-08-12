<?php if ( !defined( 'STUZZPANEL' ) ) exit; ?>
<pre class="server-log"><?php

require_once 'server-log-shared.php';

$line = 0;
foreach ( file( 'server.log' ) as $log ) {
	$log = ansi_colors( htmlspecialchars( rtrim( $log ) ) );
	if ( preg_match( '/^\tat |^\S+Exception$/', $log ) ) {
		$log = '<span class="error">' . $log . '</span>';
	} elseif ( preg_match( '/^\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d \[([A-Z]+)\]/', $log, $level ) ) {
		$log = '<span class="' . strtolower( $level[1] ) . '">' . $log . '</span>';
	}
	echo $log, "\n";
	$line++;
}

?></pre>
<form id="server_console" action="javascript:void 0" method="get"><input type="text" id="server_input" class="span8 enable-when-online" disabled></form>
<script>var logline = <?php echo $line; ?>;</script>
