<?php

header( 'Cache-Control: private, max-age=0' );
header( 'Pragma: no-cache, must-revalidate' );

// TODO: Actual keys with actual validation
if ( $_GET['k'] != 'some magical number of some variety' ) {
	exit;
}

if ( $data = json_decode( $_GET['d'], true ) ) {
	file_put_contents( 'server.dat', serialize( $data ) );
}
