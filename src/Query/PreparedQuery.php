<?php

namespace Walnut\Lib\Db\Query;

/**
 * Class PreparedQuery
 *
 */
final readonly class PreparedQuery implements Query {

	/**
	 * @param string[] $boundParams
	 */
	public function __construct(
		public string $query,
		public array  $boundParams
	) {}

	/**
	 * @param array<scalar|null>|null $boundValues
	 * @return array<string, scalar|null>
	 */
	private function filterBoundValues(array $boundValues = null): array {
		$result = [];
		foreach($this->boundParams as $param) {
			$value = is_array($boundValues) && array_key_exists($param, $boundValues) ?
				$boundValues[$param] : null;
			$result[$param] = (string)$value !== '' ? $value : null;
		}
		return $result;
	}

	/**
	 * @param array<scalar|null>|null $boundValues
	 * @param string[]|null $placeholders
	 */
	public function execute(
		QueryExecutor $queryExecutor,
		array $boundValues = null,
		array $placeholders = null
	): QueryResult {
		return $queryExecutor->execute($this->query,
			$this->filterBoundValues($boundValues));
	}

}