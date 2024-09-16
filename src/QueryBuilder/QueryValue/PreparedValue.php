<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryValue;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class PreparedValue implements SqlQueryValue {
	public function __construct(private string $parameterName) {}

	public function build(SqlQuoter $quoter): string {
		return ":$this->parameterName";
	}
}
