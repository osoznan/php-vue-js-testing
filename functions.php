<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace system;

/**
 * Creates the most simple PSR-4 autoload
 */
spl_autoload_register(function ($className) {
    $className = str_replace('app\\', 'app\\apps\\', $className);

    $alias = 'app\\apps\\';

    $length = strlen($alias);

    if (strncmp($alias, $className, $length) !== 0) {
        return;
    }

    $cleanClassName = substr($className, $length);

    $file = 'apps/' . str_replace('\\', '/', $cleanClassName) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
