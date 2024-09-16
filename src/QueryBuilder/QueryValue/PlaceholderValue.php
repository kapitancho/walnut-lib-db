<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryValue;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class PlaceholderValue implements SqlQueryValue {
	public function __construct(private string $placeholderName) {}

	public function build(SqlQuoter $quoter): string {
		return "**__" . $this->placeholderName . "__**";
	}
}
