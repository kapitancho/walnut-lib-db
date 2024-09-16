<?php

namespace Walnut\Lib\Db\QueryBuilder\Query;

use Walnut\Lib\Db\QueryBuilder\QueryPart\OrderByField;
use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\Db\QueryBuilder\QueryPart\SelectLimit;
use Walnut\Lib\Db\QueryBuilder\QueryPart\TableField;
use Walnut\Lib\Db\QueryBuilder\QueryPart\TableJoin;
use Walnut\Lib\Db\QueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class SelectQuery implements Query {
	private const SELECT_QUERY_TEMPLATE = "SELECT %s %s FROM %s AS _ %s WHERE %s %s %s";

	/**
	 * @param non-empty-array<string, string|SqlQueryValue|TableField> $fields
	 * @param list<TableJoin> $joins
	 * @param list<OrderByField> $orderBy
	 */
	public function __construct(
		public string $tableName,
		public array $fields,
		public array $joins,
		public QueryFilter $queryFilter,
		public array $orderBy = [],
		public ?SelectLimit $selectLimit = null,
		public bool $isForUpdate = false
	) {
		if (!count($this->fields)) {
			throw new \InvalidArgumentException("A select query must have at least one value specified");
		}
	}

	public function build(SqlQuoter $quoter): string {
		$fieldList = [];
		foreach($this->fields as $alias => $fieldName) {
			$fieldList[] = $alias === $fieldName ?
				"_." . $quoter->quoteIdentifier($fieldName) :
				sprintf("%s AS %s",
					(($fieldName instanceof SqlQueryValue) ||
							($fieldName instanceof TableField)) ?
						$fieldName->build($quoter) :
						"_." . $quoter->quoteIdentifier($fieldName),
					$quoter->quoteIdentifier($alias)
				);
		}
		$joinList = [];
		foreach($this->joins as $join) {
			$joinList[] = $join->build($quoter);
		}

		$orderByList = [];
		foreach($this->orderBy as $orderByField) {
			$orderByList[] = $orderByField->build($quoter);
		}
		return sprintf(self::SELECT_QUERY_TEMPLATE,
			$this->isForUpdate ? 'FOR UPDATE' : '',
			implode(', ', $fieldList),
			$quoter->quoteIdentifier($this->tableName),
			implode('', $joinList),
			$this->queryFilter->build($quoter),
			$orderByList ? "ORDER BY " . implode(', ', $orderByList) : '',
			$this->selectLimit?->build() ?? ''
		);
	}
}
