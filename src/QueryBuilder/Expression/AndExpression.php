<?php

namespace Walnut\Lib\Db\QueryBuilder\Expression;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class AndExpression implements SqlExpression {
	/** @var SqlExpression[] */
	private array $expressions;
	public function __construct(SqlExpression ...$expressions) {
		$this->expressions = $expressions;
	}
	public function build(SqlQuoter $quoter): string {
		return '(' . (count($this->expressions) > 0 ?
			implode(' AND ', array_map(
				static fn(SqlExpression $expression): string =>
					$expression->build($quoter),
				$this->expressions
			))
		: '1') . ')';
	}
}
