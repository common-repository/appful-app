<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Helper\Logger;

class ClearLogsUseCase {
	public function invoke() {
		Logger::clear_logs();
	}
}