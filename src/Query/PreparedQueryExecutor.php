<?php

namespace Walnut\Lib\Db\Query;

interface PreparedQueryExecutor {
	/**
	 * @param array<scalar|null>|null $boundParams
	 * @throws QueryExecutionException
	 */
	public function execute(array $boundParams = null): QueryResult;

	/** @param iterable<array<scalar|null>> $boundParamsArray */
	public function executeMany(iterable $boundParamsArray): void;
}