<?php

if ( ini_get( 'magic_quotes_gpc' ) ) {
	// FUCKING MAGIC QUOTES FUCK FUCK FUCK FUCK
	$_GET['d'] = stripslashes( $_GET['d'] );
}

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
	db_insert( 'mc_server_stats', array( 'username' => USERNAME, 'data' => serialize( $data ) ) );

	// Don't run cleanup every single time.
	if ( mt_rand( 0, 64 ) == 0 ) {
		global $db;
		$db->query( 'DELETE FROM `mc_server_stats` WHERE `username` = \'' . $db->escape_string( USERNAME ) . '\' AND `timestamp` < TIMESTAMPADD( HOUR, 48, NOW() ) )' );
	}
}
