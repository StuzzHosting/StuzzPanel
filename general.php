<?php if ( !defined( 'STUZZPANEL' ) ) exit; ?>
<div class="row-fluid">
	<div class="span5">
		<h2>Hosting</h2>
		<dl>
			<dt>Package</dt>
				<dd>Gold (<?php echo $server['max_mem']; ?>MB RAM)</dd>
			<dt>Price</dt>
				<dd>$20 / month</dd>
			<dt>Recommended player limit</dt>
				<dd>45 - 60</dd>
			<dt>Server address</dt>
				<dd>crapcraft.stuzzhosting.com</dd>
		</dl>
	</div>

	<div class="span5">
		<h2>Live stats</h2>
		<dl id="live-stats">
			<dt>Players (3 / <a href="change-player-cap"><?php echo $server['max_players']; ?></a>)</dt>
				<dd><?php echo implode( '<br>', $server['online_players'] ); ?></dd>
		</dl>
	</div>

	<div class="span2">
		<h2>Fake data</h2>
		<div id="gauge-cpu"></div>
		<div id="gauge-mem"></div>
		<div id="gauge-tick"></div>
	</div>
</div>

<script async src="panel.js"></script>
