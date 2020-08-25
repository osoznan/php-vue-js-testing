<?php

namespace app\site\components\storagetypes;

use app\site\components\helpers\    Mail;
use app\site\components\Storage;

class MailStorage extends Storage {

    const EMAIL = 'yuoanswami@gmail.com';

    /**
     * Saving is just a sending of e-mail
     * @return bool
     */
    public function save() {
        if ($this->validate()) {
            $attributes = $this->getAttributes();

            return Mail::sendMail(
                'Zemlyansky Alex example sender', join('<p>', [
                'You have a new acquire!',
                "name: {$attributes['name']}",
                "phone: {$attributes['phone']}",
                "description: {$attributes['description']}"
            ]));
        }

        return false;
    }

}
