<?php if ( !defined( 'STUZZPANEL' ) ) exit; ?>
<div class="row-fluid">
	<div class="span5">
		<h2>Hosting</h2>
		<dl>
			<dt>Package</dt>
				<dd><?php echo $package['name']; ?> (<?php echo MAX_MEMORY; ?>MB RAM)</dd>
			<dt>Price</dt>
				<dd>$<?php echo MAX_MEMORY * 5 / 256; ?> / month</dd>
			<dt>Recommended player limit</dt>
				<dd><?php echo $package['minplayers'], ' - ', $package['maxplayers']; ?></dd>
			<dt>Server address</dt>
				<dd><?php echo $serverinfo['ip'], '<br>(Port ', $serverinfo['port'], ')'; ?></dd>
		</dl>
	</div>

	<div class="span5" id="live_stats">
		<div class="offline<?php if ( $server['last_ping'] > time() - 15 ) echo ' hidden'; ?>">The server<br>is offline.</div>
		<h2>Live stats</h2>
		<dl>
			<dt>Players (<span id="player_count"><?php echo count( $server['online_players'] ); ?></span> / <a href="change-player-cap" id="max_players"><?php echo $server['max_players']; ?></a>)</dt>
				<dd id="player_list"><?php
if ( $server['online_players'] )
	echo implode( '<br>', $server['online_players'] );
else
	echo '<em>none</em>';
?></dd>
<?php foreach ( $server['entities'] as $world => $ent ) { ?>
			<dt><?php echo $world; ?></dt>
			<dd id="world-<?php echo $world; ?>">
				<dl class="dl-horizontal">
					<dt>Chunks loaded</dt>	<dd id="world-<?php echo $world; ?>-chunks"><?php echo $server['chunks'][$world]; ?></dd>
					<dt>Entities</dt>	<dd id="world-<?php echo $world; ?>-entities"><?php echo $ent; ?></dd>
				</dl>
			</dd>
<?php } ?>
		</dl>
	</div>

	<div class="span2">
		<div id="gauge-cpu"></div>
		<div id="gauge-mem"></div>
		<div id="gauge-tick"></div>
	</div>
</div>

<script async src="panel.js"></script>
