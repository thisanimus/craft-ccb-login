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
 * CraftccbloginModel Model
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
class User extends Model
{
    // Public Properties
    // =========================================================================
    /**
     * @var string|null
     */
    public $username;

    /**
     * @var string|null
     */
    public $password;


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

    public function loginCredentials()
    {
        


        return [
            //'username' => $this->username,
            //'password' => $this->password,
            'response' => $ccb
        ];
    }
}
