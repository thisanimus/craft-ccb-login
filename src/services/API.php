<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * Log in via the CCB API, and log user info in session.
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */

namespace thisanimus\craftccblogin\services;

use thisanimus\craftccblogin\Craftccblogin;
use thisanimus\craftccblogin\models\Settings;
//use CCB;
use Craft;
use craft\base\Component;

/**
 * 
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.0.11
 */
class API extends Component
{

    /**
     * @return mixed
     */

    protected function apiConnect(){

        $apiConnect = new \CCB\Api(Craftccblogin::$plugin->getSettings()->ccbApiUser, Craftccblogin::$plugin->getSettings()->ccbApiPassword, Craftccblogin::$plugin->getSettings()->ccbApiUrl);
        return $apiConnect;
    }

    public function logout(){
        $session = new craft\web\Session;
        
        $session->set('ccb_authenticated', false);
        $session->has('ccb_individual') ? $session->remove('ccb_individual') : false;
        $session->has('ccb_groups') ? $session->remove('ccb_groups') : false;
        $session->has('ccb_error') ? $session->remove('ccb_error') : false;
    }

    public function getUserGroups($id) 
    {

        $ccb = $this->apiConnect();

        $query = [
            'srv'=>'individual_groups',
            'individual_id'=>$id

        ];

        $data = '';

        $groupsRequest = $ccb->request($query, $data, 'GET');

        if($groupsRequest->individuals->individual->groups['count'] > 0){
            $return = $groupsRequest->individuals->individual->groups;
        }else{
            $return = false;
        }
        return $return;
    }

    public function getUser($login, $password) 
    {

        $ccb = $this->apiConnect();

        $session = new craft\web\Session;

        $query = [
            'srv'=>'individual_profile_from_login_password'
        ];

        $data = [];

        if(!empty($login)){
            $data['login'] = $login;
        }
        if(!empty($password)){
            $data['password'] = $password;
        }

        $profileRequest = $ccb->request($query, $data, 'GET');

        $user = [];

        if($profileRequest->individuals['count'] == 1){

            $individual = (array)json_decode(json_encode($profileRequest->individuals->individual), true);
            $groups = $this->getUserGroups((int)$profileRequest->individuals->individual['id']);

            $groupsArray = [];

            if($groups != false){
                foreach($groups->group as $group){
                    $groupsArray[] = (int)$group->id;
                }
            }

            $user = [
                'ccb_authenticated'=>true,
                'ccb_individual'=>$individual,
                'ccb_groups'=>$groupsArray
            ];

        }else{

            $this->logout();

            $user = [
                'ccb_authenticated'=>false,
            ];
            
            $errorString = '';
            if($profileRequest->errors['count'] > 0){
                foreach($profileRequest->errors->error as $error){
                    $errorString .= (string)$error['error'].' ';
                }
                $user['error'] = $errorString;
            }

        }

        foreach($user as $var=>$val){
            $session->set($var, $val);
        }

        return $user;
    }
}
