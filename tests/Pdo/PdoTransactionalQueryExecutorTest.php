<?php

namespace Walnut\Lib\Test\Db\Pdo;

use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\Pdo\PdoConnector;
use Walnut\Lib\Db\Pdo\PdoQueryExecutor;
use Walnut\Lib\Db\Pdo\PdoTransactionalQueryExecutor;

final class PdoTransactionalQueryExecutorTest extends TestCase {

	private function getExecutor(): PdoTransactionalQueryExecutor {
		$connector = new PdoConnector('sqlite::memory:', '', '');
		return new PdoTransactionalQueryExecutor(
			new PdoQueryExecutor($connector),
			$connector
		);
	}

	public function testOk(): void {
		$executor = $this->getExecutor();
		$this->assertEquals(
			'0',
			$executor->lastIdentity()
		);

		$this->assertEquals(
			'1',
			$executor->execute("SELECT 1")->singleValue()
		);

		$this->assertEquals(
			[1 => '1'],
			$executor->execute("SELECT 1")->first()
		);

		$this->assertEquals(
			[[1 => '1']],
			$executor->execute("SELECT 1")->all()
		);

		$this->assertEquals(
			[[1 => '1']],
			$executor->execute("SELECT 1")->collectAsList()->all()
		);

		$this->assertEquals(
			[1 => [1 => '1']],
			$executor->execute("SELECT 1 AS `key`, 1")->collectAsHash()->all()
		);

		$this->assertEquals(
			[1 => [[1 => '1']]],
			$executor->execute("SELECT 1 AS `key`, 1")->collectAsTreeData()->all()
		);
	}

	public function testSaveOk(): void {
		$executor = $this->getExecutor();
		$executor->execute("CREATE TABLE test(id integer)");
		$executor->startTransaction();
		$executor->execute("INSERT INTO test VALUES (1)");
		$executor->saveChanges();
		$this->assertEquals(
			'1',
			$executor->execute("SELECT COUNT(*) FROM test")->singleValue()
		);
	}

	public function testRevertOk(): void {
		$executor = $this->getExecutor();
		$executor->execute("CREATE TABLE test(id integer)");
		$executor->startTransaction();
		$executor->execute("INSERT INTO test VALUES (1)");
		$executor->revertChanges();
		$this->assertEquals(
			'0',
			$executor->execute("SELECT COUNT(*) FROM test")->singleValue()
		);
	}

}