<?php if ( !defined( 'STUZZPANEL' ) ) exit; ?>
<?php $first = false; foreach ( array( 'players', 'cpumem', 'tickrate' ) as $graph ) { if ( $first ) $first = false; else echo '<hr>'; ?>
<div id="graph-<?php echo $graph; ?>" style="width: 600px; height: 300px;"></div>
<?php } ?>
<script async>
$( 'a[href="#graph"]' ).click(function() {
	$.getJSON( 'index.php?api=graph&key=' + $( '#req_key' ).val(), function( data ) {
		$.each( data, function( graph, lines ) {
			var data = new google.visualization.DataTable();
			data.addColumn( 'date', 'Date' );
			var count = 0;
			$.each( lines, function( line, points ) {
				data.addColumn( 'number', line );
				if ( !count ) {
					for ( var i in points ) {
						count++;
					}
				}
			});
			data.addRows( count );
			var i = 0;
			$.each( lines, function( line, points ) {
				var j = 0;
				$.each( points, function( point, value ) {
					if ( !i ) {
						data.setValue( j, 0, new Date( point * 1000 ) );
					}
					data.setValue( j, i + 1, value );
					j++;
				} );
				i++;
			} );
			var chart = new google.visualization.AnnotatedTimeLine( document.getElementById( 'graph-' + graph ) );
			chart.draw( data, {} );
		} );
	} );
} );
</script>
