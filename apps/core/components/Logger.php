<?php

namespace app\core\components;

use osoznan\patri\Top;

class Logger extends \osoznan\patri\Component {

    public $records;

    public $filename;

    function init() {
        Top::$app->on(Top::$app::EVENT_AFTER_RUN, function() {
            $this->save();
        });
    }

    function add($str) {
        $this->records[] = ($str . ' ' . date('Y:m:d H:i:s') . PHP_EOL);
    }

    function save() {
        $fp = fopen($this->filename, 'a');
        fwrite($fp, PHP_EOL . $_SERVER['REQUEST_URI'] . PHP_EOL);
        fwrite($fp, join('', $this->records));
        fclose($fp);
    }
}
