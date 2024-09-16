<?php

namespace Walnut\Lib\Db\DataModel\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class ModelRoot {
	public function __construct(
		public string $modelRoot
	) {}
}
