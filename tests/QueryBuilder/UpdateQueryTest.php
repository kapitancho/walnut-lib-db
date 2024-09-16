<?php

namespace Walnut\Lib\Test\Db\QueryBuilder;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\QueryBuilder\Expression\RawExpression;
use Walnut\Lib\Db\QueryBuilder\Query\UpdateQuery;
use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\Db\QueryBuilder\QueryValue\PreparedValue;
use Walnut\Lib\Db\QueryBuilder\QueryValue\SqlValue;
use Walnut\Lib\Db\QueryBuilder\Quoter\MysqlQuoter;

final class UpdateQueryTest extends TestCase {

	public function testOk(): void {
		$uqb = new UpdateQuery(
			"clients", [
				"id" => new PreparedValue('id'),
				"name" => new SqlValue('Client 7')
			],
			new QueryFilter(new RawExpression("1"))
		);
		$this->assertEquals(
			"UPDATE `clients` SET `id` = :id, `name` = 'Client 7' WHERE 1",
			$uqb->build(new MysqlQuoter)
		);
	}

	public function testNoFields(): void {
		$this->expectException(InvalidArgumentException::class);
		new UpdateQuery("clients", [],
			new QueryFilter(new RawExpression("1")));
	}

}