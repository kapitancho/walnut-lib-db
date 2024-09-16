<?php

namespace Walnut\Lib\Db\QueryBuilder\Query;

use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\Db\QueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class UpdateQuery implements Query {
	private const UPDATE_QUERY_TEMPLATE = "UPDATE %s SET %s WHERE %s";

	/** @param non-empty-array<string, SqlQueryValue> $values */
	public function __construct(
		public string $tableName,
		public array $values,
		public QueryFilter $queryFilter
	) {
		if (!count($this->values)) {
			throw new \InvalidArgumentException("An update query must have at least one value specified");
		}
	}

	public function build(SqlQuoter $quoter): string {
		$setList = [];
		foreach($this->values as $fieldName => $value) {
			$setList[] = $quoter->quoteIdentifier($fieldName) . ' = ' .
				$value->build($quoter);
		}
		return sprintf(self::UPDATE_QUERY_TEMPLATE,
			$quoter->quoteIdentifier($this->tableName),
			implode(', ', $setList),
			$this->queryFilter->build($quoter)
		);
	}
}
