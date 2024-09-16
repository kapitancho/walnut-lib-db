<?php

namespace Walnut\Lib\Db\Query;

interface QueryExecutor {
	public function prepare(string $query): PreparedQueryExecutor;

	/**
	 * @param array<scalar|null>|null $boundParams
	 * @throws QueryExecutionException
	 */
	public function execute(string $query, array $boundParams = null): QueryResult;

	public function lastIdentity(): mixed;

	public function foundRows(): ?int;
}