<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * des
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */

namespace thisanimus\craftccblogin\variables;

use thisanimus\craftccblogin\Craftccblogin;

use Craft;

/**
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.1.1
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
        $userSession = ['ccb_authenticated' => false];

        foreach($session as $var=>$val){
            $userSession[$var] = $val;
        }

        return $userSession;
    }
}
