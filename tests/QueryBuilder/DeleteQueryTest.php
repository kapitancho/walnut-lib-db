<?php

namespace Walnut\Lib\Test\Db\QueryBuilder;

use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\QueryBuilder\Expression\RawExpression;
use Walnut\Lib\Db\QueryBuilder\Query\DeleteQuery;
use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\Db\QueryBuilder\Quoter\MysqlQuoter;

final class DeleteQueryTest extends TestCase {

	public function testOk(): void {
		$dqb = new DeleteQuery(
			"clients",
			new QueryFilter(new RawExpression("1"))
		);
		$this->assertEquals(
			"DELETE FROM `clients` WHERE 1",
			$dqb->build(new MysqlQuoter)
		);
	}

}