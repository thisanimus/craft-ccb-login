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
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.0.3
 */
class Settings extends Model
{
    /**
     *
     * @var string
     */
    public $ccbApiUser;
    public $ccbApiPassword;
    public $apiUrl;

    // Public Methods
    // =========================================================================

    /**
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
            ['ccbApiUrl', 'string'],
            ['ccbApiUrl', 'default', 'value' => ''],
        ];
    }
}
