<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryPart;

enum OrderByDirection: string {
	case ascending = 'ASC';
	case descending = 'DESC';
}
