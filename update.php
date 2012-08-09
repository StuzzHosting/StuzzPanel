<?php

define( 'STUZZPANEL', 'BESTPANEL' );

define( 'USERNAME', $_GET['u'] );

define( 'SKIP_AUTHENTICATION', 'grab-only' );

require_once 'database.php';

header( 'Cache-Control: private, max-age=0' );
header( 'Pragma: no-cache, must-revalidate' );

if ( $_GET['k'] != SERVER_KEY ) {
	exit;
}

if ( $data = json_decode( $_GET['d'], true ) ) {
	$data['last_ping'] = time();
	file_put_contents( 'server.dat', serialize( $data ) );
}
