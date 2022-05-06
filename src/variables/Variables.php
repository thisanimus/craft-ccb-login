<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * des
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */

namespace thisanimus\CCBLogin\variables;

use craft\web\Session;

use Craft;

/**
 * @author    Andrew Hale
 * @package   CCBLogin
 */
class Variables{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    // {{ craft.ccblogin.userSession }}//
    public function userSession()
    {   
        $session = new Session;
        $userSession = ['ccb_authenticated' => false];

        foreach($session as $var=>$val){
            $userSession[$var] = $val;
        }

        return $userSession;
    }
}
