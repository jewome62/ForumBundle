<?php

namespace Herzult\ForumBundle\Tests\Util;

use Herzult\ForumBundle\Util\Inflector;

class InflectorTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugify()
    {
        $this->assertEquals('-', Inflector::slugify(''));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo      Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('    Foo Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo Bar     '));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo-Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo / Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo Bar ...'));
    }
}
