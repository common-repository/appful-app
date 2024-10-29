<?php

namespace AppfulPlugin\Helper;

class Logger {
	private static function log( string $msg, ?string $level = null, string $name = '' ) {
		$log_level = $level ?? LoggerLevel::$DEBUG;

		if ( $log_level !== LoggerLevel::$DEBUG || ( Constants::$APPFUL_DEBUG || ( isset( $_REQUEST["debug"] ) && $_REQUEST["debug"] == "1" ) ) ) {
			$trace = debug_backtrace();
			$name  = ( '' == $name ) ? ( ( isset( $trace[1]['class'] ) ) ? $trace[1]['class'] : "Unknown" ) . "(" . $trace[1]['function'] . "):" . $trace[1]['line'] : $name;
			$name  = str_pad( substr( $name, 0, 79 ), 80 );

			$log_level = str_pad( $log_level, 8 );

			$error_dir = self::getLogFile();
			$msg       = print_r( $msg, true );
			$date      = date( 'd-m-y h:i:s' );
			$log       = "[" . $log_level . "]" . "[" . $date . "]" . " - " . $name . "  |  " . $msg . "\n";
			error_log( $log, 3, $error_dir );
		}
	}

	public static function debug( string $msg, string $name = '' ) {
		self::log( $msg, LoggerLevel::$DEBUG, $name );
	}

	public static function info( string $msg, string $name = '' ) {
		self::log( $msg, LoggerLevel::$INFO, $name );
	}

	public static function error( string $msg, string $name = '' ) {
		self::log( $msg, LoggerLevel::$ERROR, $name );
	}

	public static function clear_logs() {
		file_put_contents( self::getLogFile(), "" );
	}

	public static function get_logs(): string {
		$data = file_get_contents( self::getLogFile() );

		return ( ! $data ) ? "No logs found!" : $data;
	}

	private static function getLogFile(): string {
		return WP_PLUGIN_DIR . Constants::$PLUGIN_ROOT_DIR . "/appful.log";
	}
}
