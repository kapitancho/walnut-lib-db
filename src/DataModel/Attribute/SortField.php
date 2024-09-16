<?php

namespace Walnut\Lib\Db\DataModel\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class SortField {
	public function __construct(
		public string $name
	) {}
}