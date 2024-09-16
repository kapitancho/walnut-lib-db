<?php

namespace Walnut\Lib\Db\Pdo;

use PDOStatement;
use Walnut\Lib\Db\Query\PreparedQueryExecutor;
use Walnut\Lib\Db\Query\QueryExecutionException;
use Walnut\Lib\Db\Query\QueryResult;

final readonly class PdoPreparedQueryExecutor implements PreparedQueryExecutor {
	public function __construct(private PDOStatement $statement) {}

	/**
	 * @param array<scalar|null>|null $boundParams
	 * @return QueryResult
	 * @throws QueryExecutionException
	 */
	public function execute(array $boundParams = null): QueryResult {
		$this->statement->execute($boundParams ?? []);
		return new PdoQueryResult($this->statement);
	}

	/** @param iterable<array<scalar|null>> $boundParamsArray */
	public function executeMany(iterable $boundParamsArray): void {
		foreach ($boundParamsArray as $boundParams) {
			$this->statement->execute($boundParams);
		}
	}

}