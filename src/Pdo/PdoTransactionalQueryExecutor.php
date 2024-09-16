<?php

namespace Walnut\Lib\Db\Pdo;

use Walnut\Lib\Db\Query\QueryExecutor;
use Walnut\Lib\Db\TransactionContext\TransactionContext;

final readonly class PdoTransactionalQueryExecutor implements QueryExecutor, TransactionContext {

	public function __construct(
		private PdoQueryExecutor $queryExecutor,
		private PdoConnector     $pdoConnector
	) {}

	public function startTransaction(): void {
		$this->pdoConnector->getConnection()->beginTransaction();
	}

	public function saveChanges(): void {
		$this->pdoConnector->getConnection()->commit();
	}

	public function revertChanges(): void {
		$this->pdoConnector->getConnection()->rollBack();
	}

	public function prepare(string $query): PdoPreparedQueryExecutor {
		return $this->queryExecutor->prepare($query);
	}

	public function execute(string $query, array $boundParams = null): PdoQueryResult {
		return $this->queryExecutor->execute($query, $boundParams);
	}

	public function lastIdentity(): string {
		return $this->queryExecutor->lastIdentity();
	}

	public function foundRows(): ?int {
		// @codeCoverageIgnoreStart
		return $this->queryExecutor->foundRows();
		// @codeCoverageIgnoreEnd
	}
}