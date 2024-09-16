<?php

namespace Walnut\Lib\Db\Query;

interface Query {

	/**
	 * @param array<scalar|null>|null $boundValues
	 * @param string[]|null $placeholders
	 */
	public function execute(
		QueryExecutor $queryExecutor,
		array $boundValues = null,
		array $placeholders = null
	): QueryResult;

}