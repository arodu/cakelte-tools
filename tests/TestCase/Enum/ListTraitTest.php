<?php
declare(strict_types=1);

namespace CakeLteTools\Test\TestCase\Enum;

use Cake\TestSuite\TestCase;

/**
 * CakeLteTools\Enum\Trait\ListTrait Test Case
 */
class ListTraitTest extends TestCase
{
    /**
     * Test toListLabel.
     *
     * @return void
     */
    public function testToListLabel(): void
    {
        $this->assertSame(
            ['first' => 'First', 'second' => 'Second'],
            SampleList::toListLabel(),
        );
    }

    /**
     * Test toListLabel with an explicit subset of cases.
     *
     * @return void
     */
    public function testToListLabelWithCases(): void
    {
        $this->assertSame(
            ['first' => 'First'],
            SampleList::toListLabel([SampleList::FIRST]),
        );
    }

    /**
     * Test toListName.
     *
     * @return void
     */
    public function testToListName(): void
    {
        $this->assertSame(
            ['first' => 'FIRST', 'second' => 'SECOND'],
            SampleList::toListName(),
        );
    }

    /**
     * Test names.
     *
     * @return void
     */
    public function testNames(): void
    {
        $this->assertSame(['FIRST', 'SECOND'], SampleList::names());
    }

    /**
     * Test values.
     *
     * @return void
     */
    public function testValues(): void
    {
        $this->assertSame(['first', 'second'], SampleList::values());
    }
}
