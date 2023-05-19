<?php

declare(strict_types=1);

namespace CakeLteTools\Utility;

use Cake\Utility\Text as UtilityText;

class Text extends UtilityText
{
    /**
     * @inheritDoc
     */
    public static function insert(string $str, array $data, array $options = []): string
    {
        $options += [
            'before' => '{{', 'after' => '}}', 'escape' => '\\', 'format' => null, 'clean' => false,
        ];

        return parent::insert($str, $data, $options);
    }
}