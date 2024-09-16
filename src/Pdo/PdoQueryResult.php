<?php

namespace Walnut\Lib\Db\Pdo;

use Walnut\Lib\Db\Query\QueryResult;
use Walnut\Lib\Db\Query\ResultBag\ListResultBag;
use Walnut\Lib\Db\Query\ResultBag\TreeDataResultBag;

final readonly class PdoQueryResult implements QueryResult {

	public function __construct(
		private \PDOStatement $pdoStatement
	) { }

	public function all(): array {
		return $this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function first(): string|int|float|bool|null|array|object {
		$result = $this->pdoStatement->fetch(\PDO::FETCH_ASSOC);
		$this->pdoStatement->closeCursor();
		return $result ?: null;
	}

	public function singleValue(): string|int|float|bool|null {
		/**
		 * @var string|int|float|bool|null $result
		 */
		$result = $this->pdoStatement->fetch(\PDO::FETCH_COLUMN);
		$this->pdoStatement->closeCursor();
		return $result;
	}

	public function rowCount(): int {
		return $this->pdoStatement->rowCount();
	}

	public function collectAsList(): ListResultBag {
		return new ListResultBag($this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC));
	}

	public function collectAsTreeData(): TreeDataResultBag {
		return new TreeDataResultBag($this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC | \PDO::FETCH_GROUP));
	}

	public function collectAsHash(): ListResultBag {
		return new ListResultBag($this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC | \PDO::FETCH_UNIQUE));
	}

}