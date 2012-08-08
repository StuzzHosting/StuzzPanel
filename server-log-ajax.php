<?php if ( !defined( 'STUZZPANEL' ) ) exit; ?>
<?php

require_once 'server-log-shared.php';

$log = array();
$l = 0;
foreach ( file( 'server.log' ) as $line ) {
	$l++;
	if ( $l <= $_GET['line'] )
		continue;

	$class = '';
	$line = ansi_colors( htmlspecialchars( rtrim( $line ) ) );
	if ( preg_match( '/^\tat |^\S+Exception$/', $line ) ) {
		$class = 'error';
	} elseif ( preg_match( '/^\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d \[([A-Z]+)\]/', $line, $level ) ) {
		$class = strtolower( $level[1] );
	}
	$log[] = array( $class, $line );
}

if ( $l < $_GET['line'] )
	$l = -1;

?>
(function($) {
	$.each(<?php echo json_encode( $log ); ?>, function(_, entry) {
		$('.server-log').append( $( '<div>' ).addClass( entry[0] ).html( entry[1] ) );
	})
<?php if ( $log ) { ?>
	$('.server-log')[0].scrollTop = 1e20;
<?php } ?>
	setTimeout(function() {
		$.getScript('index.php?api=log&line=<?php echo $l; ?>')
	}, 1000);
})(jQuery)

