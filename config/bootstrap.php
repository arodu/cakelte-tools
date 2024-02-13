<?php

use Cake\Core\Configure;

Configure::load('CakeLteTools.icons', 'default', true);
if (file_exists(CONFIG . 'icons.php')) {
    Configure::load('icons', 'default', true);
}