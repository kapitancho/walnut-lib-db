<?php

namespace Walnut\Lib\Db\Orm;

use Walnut\Lib\Db\Query\PreparedQuery;


interface RelationalStorageQueryBuilder {
	public function getInsertQuery(string $modelName): PreparedQuery;
	public function getUpdateQuery(string $modelName): PreparedQuery;
	public function getDeleteQuery(string $modelName): PreparedQuery;
}