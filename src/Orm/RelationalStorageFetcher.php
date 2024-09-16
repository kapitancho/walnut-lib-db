<?php

namespace Walnut\Lib\Db\Orm;

use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;

/**
 * @template T
 * @package Walnut\Lib\Db\Orm
 */
interface RelationalStorageFetcher {
	/**
	 * @param QueryFilter $filter
	 * @return T[]
	 */
	public function fetchData(QueryFilter $filter): array;
}