<?php

namespace Walnut\Lib\Db\QueryBuilder\QueryPart;

enum TableJoinType: string {
	case innerJoin = 'JOIN';
	case leftJoin = 'LEFT JOIN';
}
