<?php

namespace AppfulPlugin\Helper;

use DateTime;
use DateTimeZone;
use Exception;

class DateParser {
	public static function fromGmtDate( string $date_string ): DateTime {
		if ( strcmp( $date_string, "0000-00-00 00:00:00" ) == 0 ) {
			return new DateTime( "1970-01-01", new DateTimeZone( "GMT" ) );
		}

		try {
			return new DateTime( $date_string, new DateTimeZone( "GMT" ) );
		} catch ( Exception $e ) {
			return new DateTime( "1970-01-01", new DateTimeZone( "GMT" ) );
		}
	}

	public static function dateToString( DateTime $date ): string {
		$date->setTimezone( new DateTimeZone( "UTC" ) );

		return $date->format( "Y-m-d\TH:i:s" );
	}
}
