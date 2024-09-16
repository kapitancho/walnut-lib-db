<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryPart;

use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;

final readonly class TableField {
	private const SQL_TEMPLATE = "%s.%s";
	public function __construct(
		private string $tableAlias,
		private string $fieldName
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::SQL_TEMPLATE,
			$quoter->quoteIdentifier($this->tableAlias),
			$quoter->quoteIdentifier($this->fieldName)
		);
	}
}
