<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * Log in via the CCB API, and log user info in session.
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */

namespace countrysidebible\craftccblogin\services;

use countrysidebible\craftccblogin\Craftccblogin;
use countrysidebible\craftccblogin\models\Settings;
//use CCB;
use Craft;
use craft\base\Component;

/**
 * CraftccbloginService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.0.0
 */
class API extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Craftccblogin::$plugin->craftccbloginService->exampleService()
     *
     * @return mixed
     */

    protected function apiConnect(){

        $apiConnect = new \CCB\Api(Craftccblogin::$plugin->getSettings()->ccbApiUser, Craftccblogin::$plugin->getSettings()->ccbApiPassword, Craftccblogin::$plugin->getSettings()->apiUrl);
        return $apiConnect;
    }

    public function logout(){
        $session = new craft\web\Session;
        
        $session->remove('authenticated');
        $session->remove('id');
        $session->remove('name');
        $session->remove('groups');
        $session->remove('error');
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

            $id = (int)$profileRequest->individuals->individual['id'];
            $name = (string)$profileRequest->individuals->individual->full_name;
            $image = (string)$profileRequest->individuals->individual->image;

            $groups = $this->getUserGroups($id);

            $groupsArray = [];

            if($groups != false){
                foreach($groups->group as $group){
                    $groupsArray[] = (int)$group->id;
                }
            }

            $user = [
                'authenticated'=>true,
                'id'=>$id,
                'name'=>$name,
                'image'=>$image,
                'groups'=>$groupsArray
            ];

            
        }else{

            $user = [
                'authenticated'=>false,
            ];
            
            $session->remove('authenticated');
            $session->remove('id');
            $session->remove('name');
            $session->remove('groups');


            $errorArray = [];

            if($profileRequest->errors['count'] > 0){
                foreach($profileRequest->errors->error as $error){
                    $errorArray[] = [(int)$error['number']=>(string)$error['error']];
                }
                $user[] = $errorArray;
            }

        }

        foreach($user as $var=>$val){
            $session->set($var, $val);
        }

        return $user;
    }
}
