<?php

function ansi_colors( $text ) {
	$split = explode( "\x1B[", $text );
	$text = $split[0];
	$closing = '';
	for ( $i = 1; $i < count( $split ); $i++ ) {
		for ( $j = 0; $j < strlen( $split[$i] ); $j++ ) {
			$char = substr( $split[$i], $j, 1 );
			if ( $char == 'm' ) {
				$text .= substr( $split[$i], $j + 1 );
				continue 2;
			}

			if ( $char == ';' ) {
				continue;
			}

			if ( $char == '0' ) {
				$text .= $closing;
				$closing = '';
				continue;
			}

			if ( $char == '1' ) {
                                $text .= '<strong>';
				$closing = '</strong>' . $closing;
				continue;
			}

			if ( $char == '3' || $char == '4' ) {
				$bg = $char == '4';
				$char = substr( $split[$i], ++$j, 1 );
				$color = 'inherit';
				switch ( $char ) {
				case '0':
					$color = 'black';
					break;
				case '1':
					$color = 'red';
					break;
				case '2':
					$color = 'green';
					break;
				case '3':
					$color = 'yellow';
					break;
				case '4':
					$color = 'blue';
					break;
				case '5':
					$color = 'magenta';
					break;
				case '6':
					$color = 'cyan';
					break;
				case '7':
					$color = 'white';
					break;
				}
				$text .= '<span style="' . ( $bg ? 'background-' : '' ) . 'color: ' . $color . '">';
				$closing = '</span>' . $closing;
				continue;
			}
		}
	}
	return $text . $closing;
}

