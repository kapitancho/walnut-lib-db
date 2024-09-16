<?php

namespace Walnut\Lib\Test\Db\Orm;

use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\DataModel\Attribute\Fields;
use Walnut\Lib\Db\DataModel\Attribute\KeyField;
use Walnut\Lib\Db\DataModel\Attribute\ModelRoot;
use Walnut\Lib\Db\DataModel\Attribute\Table;
use Walnut\Lib\Db\DataModel\DataModel;
use Walnut\Lib\Db\DataModel\DataPart;
use Walnut\Lib\Db\Orm\DataModelFactory;
use Walnut\Lib\Db\Query\PreparedQueryExecutor;
use Walnut\Lib\Db\Query\QueryExecutor;
use Walnut\Lib\Db\Query\QueryResult;
use Walnut\Lib\Db\Query\ResultBag\ListResultBag;
use Walnut\Lib\Db\Query\ResultBag\TreeDataResultBag;
use Walnut\Lib\Db\QueryBuilder\Expression\RawExpression;
use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqliteQuoter;

final class DataModelFactoryTest extends TestCase {

	public function testOk(): void {
		$dataModel = new DataModel(
			new ModelRoot('users'),
			['users' => new DataPart(
				new Table("users"),
				new Fields('username', 'password'),
				new KeyField('user_id'),
				null,
				null,
				null,
				null,
				[],
				[]
			)]
		);

		$queryExecutor = new class($this) implements QueryExecutor {
			public function __construct(private /*readonly*/ TestCase $testCase) {}

			public function prepare(string $query): PreparedQueryExecutor {}
			public function execute(string $query, array $boundParams = null): QueryResult {
				$this->testCase->assertStringContainsString('users', $query);
				return new class implements QueryResult {
					public function all(): array {}
					public function first(): string|int|float|bool|null|array|object {}
					public function singleValue(): string|int|float|bool|null {}
					public function collectAsList(): ListResultBag {
						return new ListResultBag([['user_id' => 1, 'username' => 'u', 'password' => 'p']]);
					}
					public function collectAsTreeData(): TreeDataResultBag {}
					public function collectAsHash(): ListResultBag {}
					public function rowCount(): int {}
				};
			}
			public function lastIdentity(): mixed {}
			public function foundRows(): ?int {}
		};
		$factory = new DataModelFactory(
			new SqliteQuoter,
			$queryExecutor
		);
		$this->assertEquals(
			[['user_id' => 1, 'username' => 'u', 'password' => 'p']],
			$factory->getFetcher($dataModel)->fetchData(
				new QueryFilter(new RawExpression("1"))
			)
		);
		$factory->getSynchronizer($dataModel)->synchronizeData([], [
			['user_id' => 1, 'username' => 'u', 'password' => 'p']
		]);
	}

}