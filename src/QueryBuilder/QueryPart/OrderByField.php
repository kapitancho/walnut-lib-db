<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryPart;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final class OrderByField {
	private const FIELD_TEMPLATE = '%s %s';
	public function __construct(
		private readonly string $fieldName,
		private readonly OrderByDirection $orderByDirection,
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::FIELD_TEMPLATE,
			$quoter->quoteIdentifier($this->fieldName),
			$this->orderByDirection->value
		);
	}

	public static function ascending(string $fieldName): self {
		return new self($fieldName, OrderByDirection::ascending);
	}

	public static function descending(string $fieldName): self {
		return new self($fieldName, OrderByDirection::descending);
	}
}
