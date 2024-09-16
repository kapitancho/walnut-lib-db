<?php

namespace Walnut\Lib\Test\Db\Query\ResultBag;

use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\Query\ResultBag\ListResultBag;

final class ListResultBagTest extends TestCase {

	public function testOk(): void {
		$bag = new ListResultBag([
			1 => ['id' => 1, 'name' => 'Name 1'],
			2 => ['id' => 2, 'name' => 'Name 2'],
			3 => ['id' => 3, 'name' => 'Name 3'],
		]);
		$this->assertCount(3, $bag->all());
		$this->assertNotNull($bag->withKey(1));
		$this->assertNull($bag->withKey(5));
		$this->assertEquals(['Name 1', 'Name 2', 'Name 3'], $bag->collect('name'));
		$this->assertEquals([1, 2, 3], $bag->keys());

		$newBag = $bag->modify((static function() {
			$q = yield;
			while ($q) {
				$q['name'] .= '*';
				$q = yield $q;
			}
		})());
		$this->assertEquals('Name 1*', $newBag->withKey(1)['name'] ?? '');
	}

}