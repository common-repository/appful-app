<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Helper\Logger;

class GetLogsUseCase {
	public function invoke(): string {
		return Logger::get_logs();
	}
}