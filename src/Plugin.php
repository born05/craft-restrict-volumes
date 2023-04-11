<?php

/**
 * Craft restrict volumes plugin for Craft CMS 3.x
 *
 * Decide what filetypes are allowed per volume.
 *
 * @link      https://born05.com
 * @copyright Copyright (c) 2021 Born05
 */

namespace born05\restrictvolumes;

use born05\restrictvolumes\assetbundle\AssetBundle;
use born05\restrictvolumes\models\Settings;

use Craft;
use craft\base\Model;
use craft\elements\Asset;
use craft\events\AssetEvent;
use craft\helpers\Assets as AssetsHelper;
use craft\i18n\PhpMessageSource;

use yii\base\Event;

/**
 * Class Plugin
 *
 * @author    Born05
 * @package   RestrictVolumes
 * @since     1.0.0
 */
class Plugin extends \craft\base\Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Plugin
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @inheritdoc
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    /**
     * @var bool
     */
    public bool $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@born05/restrictvolumes', $this->getBasePath());

        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::$app->i18n->translations['restrict-volumes'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'en',
            'basePath' => __DIR__ . '/translations',
            'allowOverrides' => true,
        ];

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Craft::$app->getView()->registerAssetBundle(AssetBundle::class);
        }

        Event::on(
            Asset::class,
            Asset::EVENT_BEFORE_HANDLE_FILE,
            function (AssetEvent $e) {
                $asset = $e->asset;
                $allowedKinds = $this->getSettings()->allowedKinds ?: [];

                if (!$allowedKinds || count($allowedKinds) === 0) {
                    return;
                }

                [$folderId] = AssetsHelper::parseFileLocation($asset->newLocation);
                if (!$folderId) {
                    return;
                }

                $targetVolume = Craft::$app->volumes->getVolumeById($folderId);
                if (!$targetVolume) {
                    return;
                }

                $targetVolumeHandle = $targetVolume->handle;
                if (!array_key_exists($targetVolumeHandle, $allowedKinds)) {
                    return;
                }

                $allowedVolumeFileKinds = $allowedKinds[$targetVolumeHandle];

                $kind = $asset->kind;
                if ($kind === null && $asset->filename !== null) {
                    $kind = AssetsHelper::getFileKindByExtension($asset->filename);
                } else if ($asset->kind === null) {
                    return;
                }

                if (array_key_exists($kind, $allowedVolumeFileKinds) && !$allowedVolumeFileKinds[$kind]) {
                    throw new \Exception(Craft::t('restrict-volumes', 'unallowed-error', ['kind' => $kind, 'volume' => $targetVolume->name]));
                }
            }
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'restrict-volumes/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
