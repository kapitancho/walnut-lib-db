<?php

namespace Walnut\Lib\Db\Orm;


interface RelationalStorageSynchronizer {
	public function synchronizeData(array $oldData, array $newData): void;
}