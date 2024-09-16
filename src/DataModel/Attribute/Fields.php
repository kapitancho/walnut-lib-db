<?php

namespace Walnut\Lib\Db\DataModel\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Fields {
	/** @var string[] */
	public array $fieldNames;

	public function __construct(string ...$fieldNames) {
		$this->fieldNames = $fieldNames;
	}
}
