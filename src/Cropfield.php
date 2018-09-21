<?php
/**
 * cropfield plugin for Craft CMS 3.x
 *
 * Cropfield migrated for Craft 3
 *
 * @link      https://onedarnleyroad.com
 * @copyright Copyright (c) 2018 One Darnley Road
 */

namespace onedarnleyroad\cropfield;

use onedarnleyroad\cropfield\fields\CropFieldField as CropFieldField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class Cropfield
 *
 * @author    One Darnley Road
 * @package   Cropfield
 * @since     1.0.0
 *
 */
class Cropfield extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Cropfield
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = CropFieldField::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'cropfield',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
