<?php

namespace Walnut\Lib\Test\Db\QueryBuilder;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\QueryBuilder\Query\InsertQuery;
use Walnut\Lib\Db\QueryBuilder\QueryValue\SqlValue;
use Walnut\Lib\Db\QueryBuilder\Quoter\MysqlQuoter;

final class InsertQueryTest extends TestCase {

	public function testOk(): void {
		$iqb = new InsertQuery(
			"clients", [
				"id" => new SqlValue(7),
				"name" => new SqlValue('Client 7')
			]
		);
		$this->assertEquals(
			"INSERT INTO `clients` (`id`, `name`) VALUES (7, 'Client 7')",
			$iqb->build(new MysqlQuoter)
		);
	}

	public function testNoFields(): void {
		$this->expectException(InvalidArgumentException::class);
		new InsertQuery("clients", []);
	}

}