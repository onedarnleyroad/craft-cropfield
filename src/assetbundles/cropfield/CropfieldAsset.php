<?php
/**
 * cropfield plugin for Craft CMS 3.x
 *
 * Cropfield migrated for Craft 3
 *
 * @link      https://onedarnleyroad.com
 * @copyright Copyright (c) 2018 One Darnley Road
 */

namespace onedarnleyroad\cropfield\assetbundles\cropfield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    One Darnley Road
 * @package   Cropfield
 * @since     1.0.0
 */
class CropfieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@onedarnleyroad/cropfield/assetbundles/cropfield/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/CropField.js',
        ];

        $this->css = [
            'css/CropField.css',
        ];

        parent::init();
    }
}
