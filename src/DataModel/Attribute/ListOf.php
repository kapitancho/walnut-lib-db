<?php

namespace Walnut\Lib\Db\DataModel\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_PROPERTY)]
final readonly class ListOf {
	public function __construct(
		public string  $fieldName,
		public string  $targetName,
		public ?string $sourceField = null
	) {}
}
