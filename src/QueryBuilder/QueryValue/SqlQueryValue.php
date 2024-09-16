<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryValue;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

interface SqlQueryValue {
	public function build(SqlQuoter $quoter): string;
}
