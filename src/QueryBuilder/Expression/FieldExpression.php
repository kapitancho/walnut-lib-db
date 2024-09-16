<?php

namespace Walnut\Lib\Db\QueryBuilder\Expression;

use Walnut\Lib\Db\QueryBuilder\QueryPart\TableField;
use Walnut\Lib\Db\QueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final class FieldExpression implements SqlExpression {
	private const SQL_TEMPLATE = '%s %s %s';
	public function __construct(
		private readonly string|TableField $fieldName,
		private readonly FieldExpressionOperation $op,
		private readonly string|TableField|SqlQueryValue $value
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::SQL_TEMPLATE,
			is_string($this->fieldName) ?
				$quoter->quoteIdentifier($this->fieldName) :
				$this->fieldName->build($quoter),
			$this->op->value,
			is_string($this->value) ? $quoter->quoteIdentifier($this->value) :
				$this->value->build($quoter)
		);
	}

	public static function equals(
		string|TableField $fieldName,
		string|TableField|SqlQueryValue $value
	): self {
		return new self($fieldName, FieldExpressionOperation::equals, $value);
	}
}
