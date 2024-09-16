<?php

namespace Walnut\Lib\Test\Db\Query\ResultBag;

use PHPUnit\Framework\TestCase;
use Walnut\Lib\Db\Query\ResultBag\TreeDataResultBag;

final class TreeDataResultBagTest extends TestCase {

	public function testOk(): void {
		$bag = new TreeDataResultBag([
			1 => [
				['id' => 1, 'name' => 'Name 1'],
				['id' => 2, 'name' => 'Name 2']
			],
			3 => [
				['id' => 3, 'name' => 'Name 3']
			]
		]);
		$this->assertCount(2, $bag->all());
		$this->assertNotNull($bag->withKey(1));
		$this->assertEmpty($bag->withKey(5));
		$this->assertEquals(['Name 1', 'Name 2', 'Name 3'], $bag->collect('name'));
		$this->assertEquals([1, 3], $bag->keys());

		$newBag = $bag->modify((static function() {
			$q = yield;
			while ($q) {
				$q['name'] .= '*';
				$q = yield null => $q;
			}
		})());
		$this->assertEquals('Name 1*', $newBag->withKey(1)[0]['name']);
	}

}