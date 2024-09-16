<?php

namespace Walnut\Lib\Test\Db\Query;

use Walnut\Lib\Db\Query\QueryResult;
use Walnut\Lib\Db\Query\ResultBag\ListResultBag;
use Walnut\Lib\Db\Query\ResultBag\TreeDataResultBag;

final class MockQueryResult implements QueryResult {
	public function all(): array {}
	public function first(): string|int|float|bool|null|array|object {}
	public function singleValue(): string|int|float|bool|null {}
	public function collectAsList(): ListResultBag {}
	public function collectAsTreeData(): TreeDataResultBag {}
	public function collectAsHash(): ListResultBag {}
	public function rowCount(): int {}
}