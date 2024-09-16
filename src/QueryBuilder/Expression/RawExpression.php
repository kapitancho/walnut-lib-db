<?php

namespace Walnut\Lib\Db\QueryBuilder\Expression;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class RawExpression implements SqlExpression {
	public function __construct(private string $rawValue) {}
	public function build(SqlQuoter $quoter): string {
		return $this->rawValue;
	}
}
