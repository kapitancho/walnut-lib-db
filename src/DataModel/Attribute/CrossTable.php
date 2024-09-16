<?php

namespace Walnut\Lib\Db\DataModel\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class CrossTable {
	public function __construct(
		public string $tableName,
		public string $parentField,
		public string $sourceField,
		public string $targetField
	) {}
}
