<?php

namespace Walnut\Lib\Db\QueryBuilder\Expression;

enum FieldExpressionOperation: string {
	case equals = '=';
	case nullSafeEquals = '<=>';
	case notEquals = '!=';
	case lessThan = '<';
	case lessOrEquals = '<=';
	case greaterThan = '>';
	case greaterOrEquals = '>=';
	case like = 'LIKE';
	case notLike = 'NOT LIKE';
	case regexp = 'REGEXP';
}
