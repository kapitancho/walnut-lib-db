<?php

namespace Walnut\Lib\Db\QueryBuilder\Quoter;

final class MysqlQuoter implements SqlQuoter {

	private const IDENTIFIER_CHAR = '`';
	private const ESCAPED_IDENTIFIER_CHAR = '``';

	private const VALUE_CHAR = "'";
	private const VALUE_CHARS = ['\\', "'", '"', "\0", "\n", "\r"];
	private const ESCAPED_VALUE_CHARS = ['\\\\', "\\'", '\\"', "\\0", "\\n", "\\r"];

	public function quoteIdentifier(string $identifier): string {
		return self::IDENTIFIER_CHAR . str_replace(
			self::IDENTIFIER_CHAR,
			self::ESCAPED_IDENTIFIER_CHAR,
			$identifier
		) . self::IDENTIFIER_CHAR;
	}

	public function quoteValue(string|int|float|bool|null $value): string {
		return match(gettype($value)) {
			'NULL' => 'NULL',
			'boolean' => $value ? '1' : '0',
			'string' =>
				self::VALUE_CHAR . str_replace(
					self::VALUE_CHARS,
					self::ESCAPED_VALUE_CHARS,
					$value
				) . self::VALUE_CHAR,
			default => (string)$value
		};
	}

}
