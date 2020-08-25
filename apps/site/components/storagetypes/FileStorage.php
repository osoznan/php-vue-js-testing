<?php

namespace app\site\components\storagetypes;

use osoznan\patri\Top;
use app\site\components\Storage;

class FileStorage extends Storage {

    /**
     * Saving to a file in the root dir named "data"
     * @return bool
     */
    public function save() {
        if ($this->validate()) {
            return file_put_contents(Top::$app->getConfig('basePath') . '/data/' . date('Y_m_d__H_i_s') . '.json', json_encode($this->getAttributes()));
        }

        return false;
    }

}
