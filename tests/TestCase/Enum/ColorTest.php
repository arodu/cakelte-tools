<?php
declare(strict_types=1);

namespace CakeLteTools\Test\TestCase\Enum;

use Cake\TestSuite\TestCase;
use CakeLteTools\Enum\Color;

/**
 * CakeLteTools\Enum\Color Test Case
 */
class ColorTest extends TestCase
{
    /**
     * Test the bg helper.
     *
     * @return void
     */
    public function testBg(): void
    {
        $this->assertSame('bg-primary', Color::PRIMARY->bg());
        $this->assertSame('bg-danger', Color::DANGER->bg());
    }

    /**
     * Test the text helper.
     *
     * @return void
     */
    public function testText(): void
    {
        $this->assertSame('text-info', Color::INFO->text());
    }

    /**
     * Test the badge helper (includes the base class).
     *
     * @return void
     */
    public function testBadge(): void
    {
        $this->assertSame('badge badge-success', Color::SUCCESS->badge());
    }

    /**
     * Test the btn helper (includes the base class).
     *
     * @return void
     */
    public function testBtn(): void
    {
        $this->assertSame('btn btn-warning', Color::WARNING->btn());
    }

    /**
     * Test the btnOutline helper uses the btn base with an outline prefix.
     *
     * @return void
     */
    public function testBtnOutline(): void
    {
        $this->assertSame('btn btn-outline-secondary', Color::SECONDARY->btnOutline());
    }

    /**
     * Test cssClass with and without the base class.
     *
     * @return void
     */
    public function testCssClass(): void
    {
        $this->assertSame('card card-primary', Color::PRIMARY->cssClass('card'));
        $this->assertSame('card-primary', Color::PRIMARY->cssClass('card', false));
    }

    /**
     * Test an unknown tag throws.
     *
     * @return void
     */
    public function testUnknownTagThrows(): void
    {
        $this->expectException(\BadMethodCallException::class);

        Color::PRIMARY->notATag();
    }
}
