<?php

namespace Walnut\Lib\Db\QueryBuilder\Expression;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

interface SqlExpression {
	public function build(SqlQuoter $quoter): string;
}
