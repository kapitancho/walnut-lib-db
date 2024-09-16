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
use Walnut\Lib\Db\DataModel\DataModel;
use Walnut\Lib\Db\DataModel\DataPart;
use Walnut\Lib\Db\DataModel\InvalidDataModel;

final class DataModelTest extends TestCase {

	public function testOk(): void {
		$dataModel = new DataModel(new ModelRoot('users'), ['users' => new DataPart(new Table("users"), new Fields("first_name", "last_name"), new KeyField("user_id"), new ParentField("customer_id"), new CrossTable("customer_users", 'customer_id', 'user_id', 'parent'), new SortField("sequence"), new GroupField("group_id"), [new OneOf("credentials", 'user_credentials')], [new ListOf("roles", 'user_roles')],)]);
		$this->assertNotNull($dataModel->part('users'));
	}

	public function testInvalidDataModel(): void {
		$this->expectException(InvalidDataModel::class);
		(new DataModel(new ModelRoot("root"), []))->part("any");
	}

}