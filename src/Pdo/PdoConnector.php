<?php

namespace Walnut\Lib\Db\Pdo;

final class PdoConnector {

	private ?\PDO $instance = null;

	public function __construct(
		private readonly string $dsn,
		private readonly string $username,
		private readonly string $password
	) {}

	public function getConnection(): \PDO {
		return $this->instance ??= $this->openConnection();
	}

	private function openConnection(): \PDO {
		$result = new \PDO($this->dsn, $this->username, $this->password);
		$result->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		return $result;
	}

}