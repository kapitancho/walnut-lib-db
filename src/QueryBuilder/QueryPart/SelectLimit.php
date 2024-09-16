<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryPart;

final readonly class SelectLimit {
	public function __construct(
		private int $limit,
		private int $offset
	) {}

	public function build(): string {
		return "LIMIT $this->offset, $this->limit";
	}

	public static function forPage(int $page, int $pageSize): self {
		return new self($pageSize, ($page - 1) * $pageSize);
	}
}
