<?php

namespace Walnut\Lib\Db\QueryBuilder\Expression;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class NotExpression implements SqlExpression {
	public function __construct(
		private SqlExpression $expression
	) {}
	public function build(SqlQuoter $quoter): string {
		return 'NOT (' . $this->expression->build($quoter) . ')';
	}
}
