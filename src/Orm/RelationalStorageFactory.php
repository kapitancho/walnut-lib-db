<?php

namespace Walnut\Lib\Db\Orm;

use Walnut\Lib\Db\DataModel\DataModel;


interface RelationalStorageFactory {
	public function getFetcher(DataModel $model): RelationalStorageFetcher;
	public function getSynchronizer(DataModel $model): RelationalStorageSynchronizer;
}