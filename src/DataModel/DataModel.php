<?php

namespace Walnut\Lib\Db\DataModel;

use Walnut\Lib\Db\DataModel\Attribute\ModelRoot;

final readonly class DataModel {
	/** @param array<string, DataPart> $parts */
	public function __construct(
		public ModelRoot $modelRoot,
		public array     $parts
	) {}

	public function part(string $modelName): DataPart {
		return $this->parts[$modelName] ??
			throw new InvalidDataModel("Expected model $modelName is missing");
	}
}