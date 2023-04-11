<?php

/**
 * Craft restrict volumes plugin for Craft CMS 3.x
 *
 * Decide what filetypes are allowed per volume.
 *
 * @link      https://born05.com
 * @copyright Copyright (c) 2021 Born05
 */

namespace born05\restrictvolumes\assetbundle;

use craft\web\assets\cp\CpAsset;

/**
 * @author    Born05
 * @package   RestrictVolumes
 * @since     1.0.0
 */
class AssetBundle extends \craft\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = __DIR__ . '/dist';

    /**
     * @inheritdoc
     */
    public $depends = [CpAsset::class];

    /**
     * @inheritdoc
     */
    public $css = ['css/restrict-volumes.css'];
}
