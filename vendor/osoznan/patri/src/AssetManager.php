<?php

namespace osoznan\patri;

class AssetManager extends \osoznan\patri\Component {

    /** @var AssetSet[] */
    public $assets = [];

    protected $addedAssets;
    protected $passedAssets;

    protected function walkDependencies($asset) {
        $assetClass = get_class($asset);
        if (!isset($this->passedAssets[$assetClass])) {
            $this->passedAssets[$assetClass] = true;
        } else {
            throw new \Exception('Circular reference in ' . $assetClass);
        }

        foreach ($asset->dependencies as $dependency) {
            if (!isset($this->addedAssets[$dependency])) {
                $this->walkDependencies(new $dependency);
            }
        }

        $this->addedAssets[$assetClass] = $asset;
    }

    // make a proper sequence of assets due to their dependencies
    public function buildAssetSetSequence($assets) {
        $assets = $assets ?? $this->assets;
        $this->addedAssets = [];
        $this->passedAssets = [];

        foreach ($assets as $asset) {
            $this->walkDependencies($asset);
        }

        return $this->addedAssets;
    }

    public function publish() {
        $assetList = $this->buildAssetSetSequence($this->assets);
        foreach ($assetList as $assetSet) {
            $this->publishAssetSet();
        }
    }

    public function publishAssetSet(AssetSet $asset) {
        @mkdir($asset->getDestinationPath(), null, true);

        foreach ($asset->css as $css) {
            copy($asset->sourcePath . '/' . $css, $asset->getDestinationPath($css));
        }

        foreach ($asset->js as $js) {
            copy($asset->sourcePath . '/' . $js, $asset->getDestinationPath($js));
        }
    }

}
