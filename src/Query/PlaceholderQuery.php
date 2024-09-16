<?php

namespace Walnut\Lib\Db\Query;

/**
 * Class PlaceholderQuery
 *
 */
final class PlaceholderQuery implements Query {

	/**
	 * @param string $query
	 * @param string[] $placeholders
	 */
	public function __construct(
		private readonly string $query,
		private readonly array $placeholders
	) {}

	/**
	 * @param string[]|null $placeholders
	 * @return string
	 */
	private function fillPlaceholders(array $placeholders = null): string {
		$placeholders ??= [];
		$query = $this->query;
		foreach($this->placeholders as $placeholder) {
			$query = str_replace('**__' . $placeholder . '__**',
				$placeholders[$placeholder] ?? '',
				$query);
		}
		return $query;
	}

	/**
	 * @param QueryExecutor $queryExecutor
	 * @param array<scalar|null>|null $boundValues
	 * @param string[]|null $placeholders
	 * @return QueryResult
	 */
	public function execute(
		QueryExecutor $queryExecutor,
		array $boundValues = null,
		array $placeholders = null
	): QueryResult {
		return $queryExecutor->execute($this->fillPlaceholders($placeholders));
	}

}