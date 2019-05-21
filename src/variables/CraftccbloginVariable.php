<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * des
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */

namespace countrysidebible\craftccblogin\variables;

use countrysidebible\craftccblogin\Craftccblogin;

use Craft;

/**
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.0.5
 */
class CraftccbloginVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    // {{ craft.craftccblogin.userSession }}//
    public function userSession()
    {   
        $session = new craft\web\Session;
        $userSession = ['authenticated' => false];

        foreach($session as $var=>$val){
            $userSession[$var] = $val;
        }

        return $userSession;
    }
}
