<?php

namespace Walnut\Lib\Db\QueryBuilder\Quoter;

interface SqlQuoter {
	public function quoteIdentifier(string $identifier): string;
	public function quoteValue(string|int|float|bool|null $value): string;
}
