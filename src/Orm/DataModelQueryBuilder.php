<?php

namespace Walnut\Lib\Db\Orm;

use Walnut\Lib\Db\Query\PreparedQuery;
use Walnut\Lib\Db\QueryBuilder\Expression\FieldExpression;
use Walnut\Lib\Db\QueryBuilder\Query\DeleteQuery;
use Walnut\Lib\Db\QueryBuilder\Query\InsertQuery;
use Walnut\Lib\Db\QueryBuilder\Query\UpdateQuery;
use Walnut\Lib\Db\QueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\Db\QueryBuilder\QueryValue\PreparedValue;
use Walnut\Lib\Db\QueryBuilder\Quoter\SqlQuoter;
use Walnut\Lib\Db\DataModel\DataModel;


final readonly class DataModelQueryBuilder implements RelationalStorageQueryBuilder {

	public function __construct(
		private SqlQuoter $sqlQuoter,
		private DataModel $model
	) { }

	public function getInsertQuery(string $modelName): PreparedQuery {
		$model = $this->model->part($modelName);
		$fields = [];
		$pk = $model->keyField->name;
		$fields[$pk] = new PreparedValue($pk);
		if ($model->parentField) {
			$pf = $model->parentField->name;
			$fields[$pf] = new PreparedValue($pf);
		}
		if ($model->sortField) {
			$sf = $model->sortField->name;
			$fields[$sf] = new PreparedValue($sf);
		}
		foreach($model->fields->fieldNames as $fieldName) {
			$fields[$fieldName] = new PreparedValue($fieldName);
		}
		foreach($model->oneOfFields as $oneOfField) {
			if ($sf = $oneOfField->sourceField) {
				$fields[$sf] = new PreparedValue($sf);
			}
		}
		$boundParams = array_keys($fields);
		$query = new InsertQuery(
			$model->table->tableName, $fields
		);
		return new PreparedQuery($query->build($this->sqlQuoter), $boundParams);
	}

	public function getUpdateQuery(string $modelName): PreparedQuery {
		$model = $this->model->part($modelName);
		$fields = [];
		$boundParams = [$kf = $model->keyField->name];
		if ($model->parentField) {
			$pf = $model->parentField->name;
			if ($pf !== $kf) {
				$fields[$pf] = new PreparedValue($pf);
			}
			$boundParams[] = $pf;
		}
		if ($model->sortField) {
			$sf = $model->sortField->name;
			$fields[$sf] = new PreparedValue($sf);
			$boundParams[] = $sf;
		}
		foreach($model->fields->fieldNames as $fieldName) {
			$fields[$fieldName] = new PreparedValue($fieldName);
			$boundParams[] = $fieldName;
		}
		foreach($model->oneOfFields as $oneOfField) {
			if ($sf = $oneOfField->sourceField) {
				$fields[$sf] = new PreparedValue($sf);
				$boundParams[] = $sf;
			}
		}
		if (!$fields) {
			$fields[$kf] = new PreparedValue($kf);
		}
		$query = new UpdateQuery(
			$model->table->tableName, $fields,
			new QueryFilter(FieldExpression::equals(
				$model->keyField->name,
				new PreparedValue($kf))
			)
		);
		return new PreparedQuery($query->build($this->sqlQuoter), $boundParams);
	}

	public function getDeleteQuery(string $modelName): PreparedQuery {
		$model = $this->model->part($modelName);
		$boundParams = [];
		$boundParams[] = $model->keyField->name;
		$query = new DeleteQuery(
			$model->table->tableName,
			new QueryFilter(FieldExpression::equals(
				$model->keyField->name,
				new PreparedValue($model->keyField->name))
			)
		);
		return new PreparedQuery($query->build($this->sqlQuoter), $boundParams);
	}

}