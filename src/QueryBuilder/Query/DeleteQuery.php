<?php

namespace Walnut\Lib\Db\QueryBuilder\Query;

use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class DeleteQuery implements Query {
	private const DELETE_QUERY_TEMPLATE = "DELETE FROM %s WHERE %s";
	public function __construct(
		public string $tableName,
		public QueryFilter $queryFilter
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::DELETE_QUERY_TEMPLATE,
			$quoter->quoteIdentifier($this->tableName),
			$this->queryFilter->build($quoter)
		);
	}
}
