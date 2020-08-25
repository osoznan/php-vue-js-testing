<?php

/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace osoznan\patri;

class AssetSet extends \osoznan\patri\TopObject {

    public $css = [];

    public $js = [];

    /** @var AssetSet[] */
    public $dependencies = [];

    public $sourcePath;

    public $destinationPath;

    public $urlTo;

    public function getDestinationPath($file = '') {
        return $this->destinationPath . '/' . str_replace('\\', '_', self::class) . '/' . $file;
    }

    public function getDestinationFile($file) {
        if ($file = $this->getDestinationPath($file)) {
        }
    }

}
