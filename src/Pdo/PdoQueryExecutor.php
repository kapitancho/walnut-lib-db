<?php

namespace Walnut\Lib\Db\Pdo;

use Walnut\Lib\Db\Query\PreparedQueryExecutor;
use Walnut\Lib\Db\Query\QueryExecutionException;
use Walnut\Lib\Db\Query\QueryExecutor;

final readonly class PdoQueryExecutor implements QueryExecutor {

	public function __construct(
		private PdoConnector $pdoConnector
	) {}

	public function prepare(string $query): PreparedQueryExecutor {
		$stmt = $this->pdoConnector->getConnection()->prepare($query);
		return new PdoPreparedQueryExecutor($stmt);
	}

	public function execute(string $query, array $boundParams = null): PdoQueryResult {
		try {
			$stmt = $this->pdoConnector->getConnection()->prepare($query);
			$stmt->execute($boundParams ?? []);
			return new PdoQueryResult($stmt);
		} catch (\PDOException $ex) {
			throw new QueryExecutionException($query, $ex);
		}
	}

	public function lastIdentity(): string {
		return $this->pdoConnector->getConnection()->lastInsertId();
	}

	public function foundRows(): ?int {
		// @codeCoverageIgnoreStart
		/**
		 * @var int|string|null $result
		 */
		$result = $this->pdoConnector->getConnection()->query("SELECT FOUND_ROWS()")
			->fetchAll(\PDO::FETCH_NUM)[0][0] ?? null;
		return isset($result) ? (int)$result : null;
		// @codeCoverageIgnoreEnd
	}
}