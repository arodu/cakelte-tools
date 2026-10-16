<?php
declare(strict_types=1);

namespace CakeLteTools\Test\TestCase\Utility;

use Cake\TestSuite\TestCase;
use CakeLteTools\Utility\Html;

/**
 * CakeLteTools\Utility\Html Test Case
 */
class HtmlTest extends TestCase
{
    /**
     * Test flattenArray drops null values and flattens nesting.
     *
     * @return void
     */
    public function testFlattenArray(): void
    {
        $this->assertSame(
            [1, 2, 3, 'a'],
            Html::flattenArray([[1, null], [2], [3, 'a']]),
        );
    }

    /**
     * Test classToString.
     *
     * @return void
     */
    public function testClassToString(): void
    {
        $this->assertSame('a b c', Html::classToString([['a', 'b'], 'c']));
    }

    /**
     * Test classToString skips null entries.
     *
     * @return void
     */
    public function testClassToStringSkipsNull(): void
    {
        $this->assertSame('a c', Html::classToString(['a', null, 'c']));
    }
}
