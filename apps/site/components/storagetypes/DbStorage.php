<?php

namespace app\site\components\storagetypes;

use app\site\components\Storage;

class DbStorage extends Storage {

    /**
     * Saving in DB, emulation since there's no db, just for presentation
     * returns true if success or false if fail
     * @return bool
     */
    public function save() {
        if ($this->validate()) {
            /** no action, since no db is there, so the true value is returned
             * there must be the following code if db exists:
             * return ActiveRecord::insert($this->model->getAttributes());
             */
            return true;
        }

        return false;
    }

}
