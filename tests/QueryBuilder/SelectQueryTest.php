<?php

namespace Walnut\Lib\Test\Db\QueryBuilder;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\QueryBuilder\Expression\AndExpression;
use Walnut\Lib\Db\QueryBuilder\Expression\FieldExpression;
use Walnut\Lib\Db\QueryBuilder\Expression\FieldExpressionOperation;
use Walnut\Lib\Db\QueryBuilder\Expression\NotExpression;
use Walnut\Lib\Db\QueryBuilder\Expression\OrExpression;
use Walnut\Lib\Db\QueryBuilder\Expression\RawExpression;
use Walnut\Lib\Db\QueryBuilder\Query\SelectQuery;
use Walnut\Lib\Db\QueryBuilder\QueryPart\OrderByField;
use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\Db\QueryBuilder\QueryPart\SelectLimit;
use Walnut\Lib\Db\QueryBuilder\QueryPart\TableField;
use Walnut\Lib\Db\QueryBuilder\QueryPart\TableJoin;
use Walnut\Lib\Db\QueryBuilder\QueryValue\PlaceholderValue;
use Walnut\Lib\Db\QueryBuilder\QueryValue\SqlValue;
use Walnut\Lib\Db\QueryBuilder\Quoter\MysqlQuoter;

final class SelectQueryTest extends TestCase {

	public function testOk(): void {
		$sqb = new SelectQuery(
			"clients", [
				"id" => "id",
				"clientName" => "name",
				"special" => new SqlValue("SPECIAL")
			],
			[
				new TableJoin("p", "projects", new QueryFilter(
					FieldExpression::equals(
						new TableField("_", "id"),
						new TableField("p", "client_id"),
					)
				))
			],
			new QueryFilter(
				new AndExpression(
					new OrExpression(
						new NotExpression(
							new FieldExpression('name', FieldExpressionOperation::like,
								new SqlValue("%test%"))
						),
						new FieldExpression('id', FieldExpressionOperation::greaterThan, new SqlValue(3))
					),
					new RawExpression("`name` NOT IN ('admin', 'dev')"),
					new FieldExpression('name', FieldExpressionOperation::notEquals, 'id'),
					new FieldExpression('name', FieldExpressionOperation::notLike,
						new PlaceholderValue('blacklist'))
				)
			),
			[
				OrderByField::ascending('id'),
				OrderByField::descending('name')
			],
			SelectLimit::forPage(3, 20),
			true
		);
		$this->assertEquals(
			"SELECT FOR UPDATE _.`id`, _.`name` AS `clientName`, 'SPECIAL' AS `special` FROM `clients` AS _ JOIN `projects` `p` ON `_`.`id` = `p`.`client_id` WHERE ((NOT (`name` LIKE '%test%') OR `id` > 3) AND `name` NOT IN ('admin', 'dev') AND `name` != `id` AND `name` NOT LIKE **__blacklist__**) ORDER BY `id` ASC, `name` DESC LIMIT 40, 20",
			$sqb->build(new MysqlQuoter)
		);
	}

	public function testNoFields(): void {
		$this->expectException(InvalidArgumentException::class);
		new SelectQuery("clients", [], [],
			new QueryFilter(new RawExpression("1")));
	}

}