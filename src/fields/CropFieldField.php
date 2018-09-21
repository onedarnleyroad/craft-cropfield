<?php
/**
 * cropfield plugin for Craft CMS 3.x
 *
 * Cropfield migrated for Craft 3
 *
 * @link      https://onedarnleyroad.com
 * @copyright Copyright (c) 2018 One Darnley Road
 */

namespace onedarnleyroad\cropfield\fields;

use onedarnleyroad\cropfield\Cropfield;
use onedarnleyroad\cropfield\assetbundles\cropfield\CropfieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    One Darnley Road
 * @package   Cropfield
 * @since     1.0.0
 */
class CropFieldField extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $initialCrop = 'center-center';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('cropfield', 'CropField');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['initialCrop', 'string'],
            ['initialCrop', 'default', 'value' => 'center-center'],
        ]);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'cropfield/_components/fields/CropField_settings',
            [
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        // {% do view.registerAssetBundle("onedarnleyroad\\cropfield\\assetbundles\\cropfield\\CropfieldAsset") %}
        Craft::$app->getView()->registerAssetBundle(CropfieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').CropfieldCropField(" . $jsonVars . ");");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'cropfield/_components/fields/CropField_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
            ]
        );
    }
}
