<?php

namespace app\site\components;

use app\site\models\Acquire;

class StorageFactory {

    /**
     * @param $className string Class name of a storage
     * @param $model Acquire Model with data being added
     * @return Storage
     */
    public static function createStorage($className, $model) {
        return new $className($model);
    }

}
