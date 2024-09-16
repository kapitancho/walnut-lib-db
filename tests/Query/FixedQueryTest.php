<?php

namespace Walnut\Lib\Test\Db\Query;

use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\Query\FixedQuery;
use Walnut\Lib\Db\Query\PreparedQueryExecutor;
use Walnut\Lib\Db\Query\QueryExecutor;
use Walnut\Lib\Db\Query\QueryResult;

require_once __DIR__ . '/mocks.inc.php';

final class FixedQueryTest extends TestCase {
	public const SQL_QUERY = "SELECT id FROM users";
	public function testOk(): void {
		$query = new FixedQuery(self::SQL_QUERY);
		
		$query->execute(new class($this) implements QueryExecutor {
			public function __construct(private TestCase $testCase) {}
			public function prepare(string $query): PreparedQueryExecutor {}
			public function execute(string $query, array $boundParams = null): QueryResult {
				$this->testCase->assertEquals(FixedQueryTest::SQL_QUERY, $query);
				return new MockQueryResult;
			}
			public function lastIdentity(): mixed {}
			public function foundRows(): ?int {}
		});
	}
	
}