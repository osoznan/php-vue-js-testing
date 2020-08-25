<?php

namespace app\site\components\helpers;

use osoznan\patri\Top;

class Mail {

    public static function sendMail($subject, $message) {
        $to = Top::$app->getConfig('email');
        $from = 'no-reply@' . $to;
        $subject .= ' (' . Top::$app->baseUrl . ')';

        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset="utf-8"',
            'From' => $from,
            'Reply-To' => $from,
            'X-Mailer' => 'PHP/' . phpversion()
        ];

        $res = Top::$app->get('mailer')->send($to, $subject, $message, join("\r\n", $headers));

        return $res;
    }

}
