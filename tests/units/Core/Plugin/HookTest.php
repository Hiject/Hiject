<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/../../Base.php';

use Hiject\Core\Plugin\Hook;

class HookTest extends Base
{
    public function testGetListeners()
    {
        $hook = new Hook();
        $this->assertEmpty($hook->getListeners('myhook'));

        $hook->on('myhook', 'A');
        $hook->on('myhook', 'B');

        $this->assertEquals(['A', 'B'], $hook->getListeners('myhook'));
    }

    public function testExists()
    {
        $hook = new Hook();
        $this->assertFalse($hook->exists('myhook'));

        $hook->on('myhook', 'A');

        $this->assertTrue($hook->exists('myhook'));
    }

    public function testMergeWithNoBinding()
    {
        $hook = new Hook();
        $values = ['A', 'B'];

        $result = $hook->merge('myhook', $values, ['p' => 'c']);
        $this->assertEquals($values, $result);
    }

    public function testMergeWithBindings()
    {
        $hook = new Hook();
        $values = ['A', 'B'];
        $expected = ['A', 'B', 'c', 'D'];

        $hook->on('myhook', function ($p) {
            return [$p];
        });

        $hook->on('myhook', function () {
            return ['D'];
        });

        $result = $hook->merge('myhook', $values, ['p' => 'c']);
        $this->assertEquals($expected, $result);
        $this->assertEquals($expected, $values);
    }

    public function testMergeWithBindingButReturningBadData()
    {
        $hook = new Hook();
        $values = ['A', 'B'];
        $expected = ['A', 'B'];

        $hook->on('myhook', function () {
            return 'string';
        });

        $result = $hook->merge('myhook', $values);
        $this->assertEquals($expected, $result);
        $this->assertEquals($expected, $values);
    }

    public function testFirstWithNoBinding()
    {
        $hook = new Hook();

        $result = $hook->first('myhook', ['p' => 2]);
        $this->assertEquals(null, $result);
    }

    public function testFirstWithMultipleBindings()
    {
        $hook = new Hook();

        $hook->on('myhook', function ($p) {
            return $p + 1;
        });

        $hook->on('myhook', function ($p) {
            return $p;
        });

        $result = $hook->first('myhook', ['p' => 3]);
        $this->assertEquals(4, $result);
    }

    public function testHookWithReference()
    {
        $hook = new Hook();

        $hook->on('myhook', function (&$p) {
            $p = 2;
        });

        $param = 123;
        $result = $hook->reference('myhook', $param);
        $this->assertSame(2, $result);
        $this->assertSame(2, $param);
    }
}
