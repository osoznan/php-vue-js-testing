<?php
namespace app\spec\system;

use osoznan\patri\AssetManager;
use osoznan\patri\Top;

class ParentAssetSetTest extends AssetSet {
    public $css = ['1_1.css', '1_2.css'];
    public $js = ['1_1.js', '1_2.js'];
}

class ChildAssetSetTest extends AssetSet {
    public $css = ['2_1.css', '2_2.css'];
    public $js = ['2_1.js', '2_2.js'];
    public $dependencies = [ParentAssetSetTest::class];
}

class Child2AssetSetTest extends AssetSet {
    public $css = ['3_1.css', '3_2.css'];
    public $js = ['3_1.js', '3_2.js'];
    public $dependencies = [Child2AssetSetTest::class];
}

class Child3AssetSetTest extends AssetSet {
    public $css = ['4_1.css', '4_2.css'];
    public $js = ['4_1.js', '4_2.js'];
    public $dependencies = [ParentAssetSetTest::class, ChildAssetSetTest::class];
}

describe('App', function() {
    beforeEach(function() {
    });

    it('getAssetSetSequence', function() {
        $class = new AssetManager();

        $class->getAssetSetSequence();

        var_dump($class->addedAssets);

    });
});
