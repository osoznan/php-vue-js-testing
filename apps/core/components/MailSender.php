<?php

namespace app\core\components;

use osoznan\patri\Component;

class MailSender extends Component {
    const EVENT_SUCCESS = 'success';
    const EVENT_ERROR = 'error';

    public function send($to, $subject, $message, $headers) {
        $res = mail($to, $subject, $message, $headers);
        if ($res) {
            $this->trigger(static::EVENT_SUCCESS);
            return true;
        }

        $this->trigger(static::EVENT_ERROR);
        return false;
    }
}
