<?php

namespace Walnut\Lib\Db\DataModel;

use Walnut\Lib\Db\DataModel\Attribute\CrossTable;
use Walnut\Lib\Db\DataModel\Attribute\Fields;
use Walnut\Lib\Db\DataModel\Attribute\GroupField;
use Walnut\Lib\Db\DataModel\Attribute\KeyField;
use Walnut\Lib\Db\DataModel\Attribute\ListOf;
use Walnut\Lib\Db\DataModel\Attribute\OneOf;
use Walnut\Lib\Db\DataModel\Attribute\ParentField;
use Walnut\Lib\Db\DataModel\Attribute\SortField;
use Walnut\Lib\Db\DataModel\Attribute\Table;

final readonly class DataPart {
	/**
	 * @param OneOf[] $oneOfFields
	 * @param ListOf[] $listOfFields
	 */
	public function __construct(
		public Table        $table,
		public Fields       $fields,
		public KeyField     $keyField,
		public ?ParentField $parentField,
		public ?CrossTable  $crossTable,
		public ?SortField   $sortField,
		public ?GroupField  $groupField,
		public array        $oneOfFields,
		public array        $listOfFields
	) {}
}