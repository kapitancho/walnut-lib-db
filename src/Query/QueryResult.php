<?php

namespace Walnut\Lib\Db\Query;

use Walnut\Lib\Db\Query\ResultBag\ListResultBag;
use Walnut\Lib\Db\Query\ResultBag\TreeDataResultBag;

interface QueryResult {
	public function all(): array;

	public function first(): string|int|float|bool|null|array|object;
	public function singleValue(): string|int|float|bool|null;

	public function collectAsList(): ListResultBag;
	public function collectAsTreeData(): TreeDataResultBag;
	public function collectAsHash(): ListResultBag;
	public function rowCount(): int;
}