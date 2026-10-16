<?php
declare(strict_types=1);

namespace CakeLteTools\Test\TestCase\Utility;

use Cake\TestSuite\TestCase;
use CakeLteTools\Utility\FaIcon;

/**
 * CakeLteTools\Utility\FaIcon Test Case
 */
class FaIconTest extends TestCase
{
    /**
     * Test getIcon with a known key.
     *
     * @return void
     */
    public function testGetIconKnownKey(): void
    {
        $this->assertSame(['fas', 'user-circle'], FaIcon::getIcon('user'));
    }

    /**
     * Test getIcon without a key returns all defaults.
     *
     * @return void
     */
    public function testGetIconAll(): void
    {
        $icons = FaIcon::getIcon();

        $this->assertArrayHasKey('user', $icons);
        $this->assertArrayHasKey('check', $icons);
    }

    /**
     * Test setIcon with a string key.
     *
     * @return void
     */
    public function testSetIconString(): void
    {
        FaIcon::setIcon('custom', ['fas', 'star']);

        $this->assertSame(['fas', 'star'], FaIcon::getIcon('custom'));
    }

    /**
     * Test setIcon with an array of icons.
     *
     * @return void
     */
    public function testSetIconArray(): void
    {
        FaIcon::setIcon(['acustom' => ['fas', 'anchor']]);

        $this->assertSame(['fas', 'anchor'], FaIcon::getIcon('acustom'));
    }
}
