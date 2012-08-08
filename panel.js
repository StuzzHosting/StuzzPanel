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
		$.getJSON('index.php?api=load', function(load) {
			cpuData.setValue(0, 0, load.cpu);
			cpu.draw(cpuData, cpuOptions);

			memData.setValue(0, 0, load.mem);
			memOptions.max = memOptions.redTo = load.maxmem;
			memOptions.redFrom = memOptions.yellowTo = load.maxmem * .9;
			memOptions.yellowFrom = memOptions.greenTo = load.maxmem * .75;

			mem.draw(memData, memOptions);

			tickData.setValue(0, 0, load.tick);
			tick.draw(tickData, tickOptions);
		});
	}, 2500);

	setInterval(function() {
		$.getJSON('index.php?api=players', function(players) {
			$('#max_players').text(players.max);
			$('#player_count').text(players.list.length);
			$('#player_list').html(players.list.join('<br>'));
		});
	}, 5000);
});

