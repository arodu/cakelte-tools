<?php
declare(strict_types=1);

namespace CakeLteTools\Test\TestCase\Utility;

use Cake\TestSuite\TestCase;
use CakeLteTools\Utility\Text;

/**
 * CakeLteTools\Utility\Text Test Case
 */
class TextTest extends TestCase
{
    /**
     * Test insert replaces placeholders with the default delimiters.
     *
     * @return void
     */
    public function testInsert(): void
    {
        $this->assertSame('Hello World', Text::insert('Hello {{name}}', ['name' => 'World']));
    }
}
