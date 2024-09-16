<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryPart;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class TableJoin {
	private const JOIN_TEMPLATE = "%s %s %s ON %s";
	public function __construct(
		private string $tableAlias,
		private string $tableName,
		private QueryFilter $queryFilter,
		private TableJoinType $tableJoinType = TableJoinType::innerJoin
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(
			self::JOIN_TEMPLATE,
			$this->tableJoinType->value,
			$quoter->quoteIdentifier($this->tableName),
			$quoter->quoteIdentifier($this->tableAlias),
			$this->queryFilter->build($quoter)
		);
	}
}
