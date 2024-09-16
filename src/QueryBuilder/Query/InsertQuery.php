<?php

namespace Walnut\Lib\Db\QueryBuilder\Query;

use Walnut\Lib\Db\QueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class InsertQuery implements Query {
	private const INSERT_QUERY_TEMPLATE = "INSERT INTO %s (%s) VALUES (%s)";

	/** @param non-empty-array<string, SqlQueryValue> $values */
	public function __construct(
		public string $tableName,
		public array $values
	) {
		if (!count($this->values)) {
			throw new \InvalidArgumentException("An insert query must have at least one value specified");
		}
	}

	public function build(SqlQuoter $quoter): string {
		$fieldList = [];
		$valueList = [];
		foreach($this->values as $fieldName => $value) {
			$fieldList[] = $quoter->quoteIdentifier($fieldName);
			$valueList[] = $value->build($quoter);
		}
		return sprintf(self::INSERT_QUERY_TEMPLATE,
			$quoter->quoteIdentifier($this->tableName),
			implode(', ', $fieldList),
			implode(', ', $valueList)
		);
	}

}
