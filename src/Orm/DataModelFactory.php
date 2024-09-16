<?php

namespace Walnut\Lib\Db\Orm;

use Walnut\Lib\Db\Query\QueryExecutor;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;
use Walnut\Lib\Db\DataModel\DataModel;


final readonly class DataModelFactory implements RelationalStorageFactory {

	public function __construct(
		private SqlQuoter     $sqlQuoter,
		private QueryExecutor $queryExecutor
	) {}

	public function getFetcher(DataModel $model): RelationalStorageFetcher {
		return new DataModelFetcher(
			$this->sqlQuoter,
			$this->queryExecutor,
			$model
		);
	}

	public function getSynchronizer(DataModel $model): RelationalStorageSynchronizer {
		return new DataModelSynchronizer(
			$this->queryExecutor,
			new DataModelCachedQueryBuilder(
				new DataModelQueryBuilder(
					$this->sqlQuoter,
					$model
				)
			),
			$model
		);
	}

}