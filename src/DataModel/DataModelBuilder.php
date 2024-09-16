<?php

namespace Walnut\Lib\Db\DataModel;

interface DataModelBuilder {
	/**
	 * @param class-string $modelClass
	 * @throws InvalidDataModel
	 */
	public function build(string $modelClass): DataModel;
}