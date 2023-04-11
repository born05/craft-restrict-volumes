<?php

/**
 * Craft restrict volumes plugin for Craft CMS 3.x
 *
 * Decide what filetypes are allowed per volume.
 *
 * @link      https://born05.com
 * @copyright Copyright (c) 2021 Born05
 */

namespace born05\restrictvolumes\models;

/**
 * @author    Born05
 * @package   RestrictVolumes
 * @since     1.0.0
 */
class Settings extends \craft\base\Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $allowedKinds = [];

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['allowedKinds', 'default', 'value' => []],
        ];
    }
}
