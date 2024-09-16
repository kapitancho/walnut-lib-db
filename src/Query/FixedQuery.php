<?php

namespace Walnut\Lib\Db\Query;

/**
 * Class FixedQuery
 *
 */
final class FixedQuery implements Query {

	public function __construct(
		public readonly string $query
	) {}

	/**
	 * @param QueryExecutor $queryExecutor
	 * @param array<scalar|null>|null $boundValues
	 * @param string[]|null $placeholders
	 * @return QueryResult
	 */
	public function execute(
		QueryExecutor $queryExecutor,
		array $boundValues = null,
		array $placeholders = null
	): QueryResult {
		return $queryExecutor->execute($this->query, []);
	}

}