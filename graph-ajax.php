<?php if ( !defined( 'STUZZPANEL' ) ) exit;

ob_start( 'ob_gzhandler' );

global $db;
$res = $db->query( 'SELECT `timestamp`, `data` FROM `mc_server_stats` WHERE `username` = \'' . $db->escape_string( USERNAME ) . '\' ORDER BY `timestamp` DESC;' );

$graphs = array();

$i = 0;
while ( $row = $res->fetch_assoc() ) {
	if ( $i++ != 0 ) {
		if ( $i == 4 ) {
			$i = 0;
		}
		continue;
	}
	$timestamp = strtotime( $row['timestamp'] );
	$data = unserialize( $row['data'] );

	$graphs['players' ]['Player limit'    ][$timestamp] = $data['max_players'];
	$graphs['players' ]['Online players'  ][$timestamp] = count( $data['online_players'] );

	$graphs['cpumem'  ]['CPU'             ][$timestamp] = $data['cpu'];
	$graphs['cpumem'  ]['Memory'          ][$timestamp] = $data['mem'] / $data['max_mem'] * 100;

	$graphs['tickrate']['Ticks per second'][$timestamp] = $data['tick'];
}

$res->close();

header( 'Content-Type: application/json' );
echo json_encode( $graphs );

