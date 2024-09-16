<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryValue;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class SqlValue implements SqlQueryValue {
	public function __construct(private int|float|string|bool|null $value) {}

	public function build(SqlQuoter $quoter): string {
		return $quoter->quoteValue($this->value);
	}
}
