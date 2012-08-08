<?php if ( !defined( 'STUZZPANEL' ) ) exit; ?>
<div class="row-fluid">
	<div class="span5">
		<h2>Hosting</h2>
		<dl>
			<dt>Package</dt>
				<dd>Stone (<?php echo $server['max_mem']; ?>MB RAM)</dd>
			<dt>Price</dt>
				<dd>$10 / month</dd>
			<dt>Recommended player limit</dt>
				<dd>15 - 30</dd>
			<dt>Server address</dt>
				<dd>crapcraft.stuzzhosting.com</dd>
		</dl>
	</div>

	<div class="span5">
		<h2>Live stats</h2>
		<dl>
			<dt>Players (<span id="player_count"><?php echo count( $server['online_players'] ); ?></span> / <a href="change-player-cap" id="max_players"><?php echo $server['max_players']; ?></a>)</dt>
				<dd id="player_list"><?php echo implode( '<br>', $server['online_players'] ); ?></dd>
		</dl>
	</div>

	<div class="span2">
		<div id="gauge-cpu"></div>
		<div id="gauge-mem"></div>
		<div id="gauge-tick"></div>
	</div>
</div>

<script async src="panel.js"></script>
