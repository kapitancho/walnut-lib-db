<?php

namespace Walnut\Lib\Db\DataModel\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class GroupField {
	public function __construct(
		public string $name
	) {}
}