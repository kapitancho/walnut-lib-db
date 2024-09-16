<?php

namespace Walnut\Lib\Db\QueryBuilder\Query;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

interface Query {
	public function build(SqlQuoter $quoter): string;
}
