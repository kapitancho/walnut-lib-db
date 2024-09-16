<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryPart;

use Walnut\Lib\Db\QueryBuilder\Expression\SqlExpression;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class QueryFilter {
	public function __construct(
		private SqlExpression $sqlExpression
	) {}

	public function build(SqlQuoter $quoter): string {
		return $this->sqlExpression->build($quoter);
	}
}
