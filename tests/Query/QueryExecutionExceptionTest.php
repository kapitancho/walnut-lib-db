<?php

namespace Walnut\Lib\Test\Db\Query;

use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\Query\QueryExecutionException;

require_once __DIR__ . '/mocks.inc.php';

final class QueryExecutionExceptionTest extends TestCase {
	public function testOk(): void {
		$exception = new QueryExecutionException("[SQL]");
		$this->assertStringContainsString("[SQL]", $exception->getMessage());
	}
	
}