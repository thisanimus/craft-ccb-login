<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * Log in via the CCB API, and log user info in session.
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */

namespace countrysidebible\craftccblogin\models;

use countrysidebible\craftccblogin\Craftccblogin;

use Craft;
use craft\base\Model;

/**
 * Craftccblogin Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $ccbApiUser;
    public $ccbApiPassword;
    public $apiUrl;
    public $baseUrl;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['ccbApiUser', 'string'],
            ['ccbApiUser', 'default', 'value' => ''],
            ['ccbApiPassword', 'string'],
            ['ccbApiPassword', 'default', 'value' => ''],
        ];
    }
}
