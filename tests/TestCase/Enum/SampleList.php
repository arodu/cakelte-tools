<?php
declare(strict_types=1);

namespace CakeLteTools\Test\TestCase\Enum;

use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\BasicEnumTrait;
use CakeLteTools\Enum\Trait\ListTrait;

/**
 * Sample enum implementing the list traits, used by ListTraitTest.
 */
enum SampleList: string implements ListInterface
{
    use ListTrait;
    use BasicEnumTrait;

    case FIRST = 'first';
    case SECOND = 'second';
}
