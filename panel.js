google.setOnLoadCallback(function() {
	var cpuData = google.visualization.arrayToDataTable([
		['CPU'],
		[    0]
	]), memData = google.visualization.arrayToDataTable([
		['Memory'],
		[       0]
	]), tickData = google.visualization.arrayToDataTable([
		['Tick rate'],
		[         20]
	]), cpuOptions = {
		redFrom: 90,
		redTo: 100,
		yellowFrom: 75,
		yellowTo: 90,
		greenFrom: 0,
		greenTo: 75
	}, memOptions = {
		greenFrom: 0
	}, tickOptions = {
		redFrom: 0,
		redTo: 15,
		yellowFrom: 15,
		yellowTo: 19,
		greenFrom: 19,
		greenTo: 20,
		max: 20
	}, cpu	= new google.visualization.Gauge(document.querySelector('#gauge-cpu')),
	mem	= new google.visualization.Gauge(document.querySelector('#gauge-mem')),
	tick	= new google.visualization.Gauge(document.querySelector('#gauge-tick'));

	cpu.draw(cpuData, cpuOptions);
	mem.draw(memData, memOptions);
	tick.draw(tickData, tickOptions);

	setInterval(function() {
		$.getJSON('index.php?api=stats', function(stats) {
			cpuData.setValue(0, 0, stats.online ? stats.cpu : 0);
			cpu.draw(cpuData, cpuOptions);

			memData.setValue(0, 0, stats.online ? stats.mem : 0);
			memOptions.max = memOptions.redTo = stats.maxmem;
			memOptions.redFrom = memOptions.yellowTo = stats.maxmem * .9;
			memOptions.yellowFrom = memOptions.greenTo = stats.maxmem * .75;
			mem.draw(memData, memOptions);

			tickData.setValue(0, 0, stats.online ? stats.tick : 0);
			tick.draw(tickData, tickOptions);

			$('#max_players').text(stats.max);
			$('#player_count').text(stats.list.length);
			$('#player_list').html(stats.list.join('<br>') || '<em>none</em>');

			$.each(stats.chunk, function(world, chunks) {
				$('#world-' + world + '-chunks').text(chunks);
			});

			$.each(stats.ent, function(world, ents) {
				$('#world-' + world + '-entities').text(ents);
			});

			if ( stats.online ) {
				$( '#offline' ).addClass( 'hidden' );
				$( '.enable-when-online' ).removeAttr( 'disabled' );
				$( '.enable-when-offline' ).attr( 'disabled', 'disabled' );
			} else {
				$( '#offline' ).removeClass( 'hidden' );
				$( '.enable-when-online' ).attr( 'disabled', 'disabled' );
				$( '.enable-when-offline' ).removeAttr( 'disabled' );
			}
		});
	}, 2500);
});

$(function() {
	$('#button_start_server').click(function() {
		$('a[href="#server-log"]').click();
		$.getJSON( 'index.php?api=start&key=' + $( '#req_key' ).val() );
	});

	$('#button_stop_server').click(function() {
		$('a[href="#server-log"]').click();
		$.getJSON( 'index.php?api=send&cmd=stop&key=' + $( '#req_key' ).val() );
	});
});

