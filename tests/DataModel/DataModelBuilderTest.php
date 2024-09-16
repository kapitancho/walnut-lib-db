<?php

namespace Walnut\Lib\Test\Db\DataModel;

use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\DataModel\Attribute\CrossTable;
use Walnut\Lib\Db\DataModel\Attribute\Fields;
use Walnut\Lib\Db\DataModel\Attribute\GroupField;
use Walnut\Lib\Db\DataModel\Attribute\KeyField;
use Walnut\Lib\Db\DataModel\Attribute\ListOf;
use Walnut\Lib\Db\DataModel\Attribute\ModelRoot;
use Walnut\Lib\Db\DataModel\Attribute\OneOf;
use Walnut\Lib\Db\DataModel\Attribute\ParentField;
use Walnut\Lib\Db\DataModel\Attribute\SortField;
use Walnut\Lib\Db\DataModel\Attribute\Table;
use Walnut\Lib\Db\DataModel\DataModelBuilder;
use Walnut\Lib\Db\DataModel\InvalidDataModel;
use Walnut\Lib\Db\DataModel\ReflectionDataModelBuilder;

final class MockInvalidDataModel {
}

#[ModelRoot('users')]
final class MockDataModel {

	#[Table("users")]
	#[Fields("first_name", "last_name")]
	#[KeyField("user_id")]
	#[ParentField("customer_id")]
	#[CrossTable("customer_users", 'customer_id', 'user_id', 'parent')]
	#[SortField("sequence")]
	#[GroupField("group_id")]
	#[OneOf("credentials", 'user_credentials')]
	#[ListOf("roles", 'user_roles')]
	public array $users;

}

final class DataModelBuilderTest extends TestCase {

	public function testOk(): void {
		$dataModelBuilder = new ReflectionDataModelBuilder;
		$dataModel = $dataModelBuilder->build(MockDataModel::class);
		$this->assertNotNull($dataModel->part('users'));
	}

	public function testInvalidModelRoot(): void {
		$this->expectException(InvalidDataModel::class);
		$dataModelBuilder = new ReflectionDataModelBuilder;
		$dataModelBuilder->build(MockInvalidDataModel::class);
	}

}