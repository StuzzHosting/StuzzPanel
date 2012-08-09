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
);

CREATE TABLE IF NOT EXISTS `mc_servers` (
	`id`      	int(11)    	NOT NULL AUTO_INCREMENT,
	`username`	varchar(8) 	NOT NULL,
	`node`    	varchar(18)	NOT NULL,
	`name`    	varchar(64)	NOT NULL,
	`ip`      	varchar(64)	NOT NULL,
	`port`    	int(11)    	NOT NULL DEFAULT '25565',
	`ram`     	varchar(4) 	NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `mc_server_stats` (
	`username` 	char(8)    	NOT NULL,
	`timestamp`     timestamp	NOT NULL,
	`data`     	text     	NOT NULL,
	KEY `timestamp` (`timestamp`)
);

*/

require_once 'config.php';

$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
if ( $db->connect_error ) {
	exit( 'Could not connect to database: Error ' . $db->connect_errno );
}

function single_query( $q, $arg ) {
	global $db;

	$stmt = $db->prepare( $q );

	$stmt->bind_param( 's', $arg );

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

function db_insert( $table, $values ) {
	global $db;

	$q = 'INSERT INTO `' . $table . '` (`' . implode( '`,`', array_keys( $values ) ) . '`) VALUES(';
	$first = true;
	foreach ( $values as $value ) {
		if ( $first ) {
			$first = false;
		} else {
			$q .= ',';
		}
		$q .= '\'' . $db->escape_string( $value ) . '\'';
	}
	$q .= ')';

	$db->query( $q );
}

if ( !defined( 'SKIP_AUTHENTICATION' ) ) {
	require_once 'authentication.php';
}

if ( !defined( 'SKIP_AUTHENTICATION' ) || constant( 'SKIP_AUTHENTICATION' ) === 'grab-only' ) {
	if ( !single_query( 'SELECT `minecraft` FROM `accounts` WHERE `username` = ?', USERNAME ) ) {
		header( 'Status: 403', true, 403 );
		require_once 'access-denied.php';
		exit;
	}

	define( 'SERVER_KEY', single_query( 'SELECT `key` FROM `accounts` WHERE `username` = ?', USERNAME ) );

	$serverinfo = multi_query( 'SELECT * FROM `mc_servers` WHERE `username` = ?', USERNAME );

	define( 'MAX_MEMORY', $serverinfo['ram'] );
}
