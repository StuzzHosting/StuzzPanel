<?php

if ( !defined( 'STUZZPANEL' ) )
	exit;

/*
	
CREATE TABLE IF NOT EXISTS `accounts` (
	`username` 	varchar(8)	NOT NULL,
	`key`      	text      	NOT NULL,
	`minecraft`	int(11)   	NOT NULL,
	`mumble`   	int(11)   	NOT NULL,
	`suspended`	int(11)   	NOT NULL,
	PRIMARY KEY (`username`)
)

CREATE TABLE IF NOT EXISTS `mc_servers` (
	`id`      	int(11)    	NOT NULL AUTO_INCREMENT,
	`username`	varchar(8) 	NOT NULL,
	`node`    	varchar(18)	NOT NULL,
	`name`    	varchar(64)	NOT NULL,
	`ip`      	varchar(64)	NOT NULL,
	`port`    	int(11)    	NOT NULL DEFAULT '25565',
	`ram`     	varchar(4) 	NOT NULL,
	PRIMARY KEY (`id`)
)

*/

require_once 'config.php';

define( 'USERNAME', 'crapcraf' );

$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
if ( $db->connect_error ) {
	exit( 'Could not connect to database: Error ' . $db->connect_errno );
}

function single_query( $q, $args ) {
	global $db;

	$stmt = $db->prepare( $q );

	foreach ( $args as $arg ) {
		$stmt->bind_param( 's', $arg );
	}

	$stmt->execute();

	$stmt->bind_result( $result );

	$stmt->fetch();

	$stmt->close();

	return $result;
}

function multi_query( $q, $arg ) {
	global $db;

	$arg = $db->escape_string( $arg );

	$res = $db->query( str_replace( '?', '\'' . $arg . '\'', $q ) );

	return $res->fetch_assoc();
}

if ( !single_query( 'SELECT `minecraft` FROM `accounts` WHERE `username` = ?', array( USERNAME ) ) ) {
	header( 'Status: 403', true, 403 );
	require_once 'access-denied.php';
	exit;
}

define( 'SERVER_KEY', single_query( 'SELECT `key` FROM `accounts` WHERE `username` = ?', array( USERNAME ) ) );

$serverinfo = multi_query( 'SELECT * FROM `mc_servers` WHERE `username` = ?', USERNAME );

define( 'MAX_MEMORY', $serverinfo['ram'] );
