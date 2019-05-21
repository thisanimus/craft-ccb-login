<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * Log in via the CCB API, and log user info in session.
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */


namespace countrysidebible\craftccblogin;

use countrysidebible\craftccblogin\services\CraftccbloginService as CraftccbloginServiceService;
use countrysidebible\craftccblogin\variables\CraftccbloginVariable;
use countrysidebible\craftccblogin\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.0.7
 *
 * @property  CraftccbloginServiceService $craftccbloginService
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class Craftccblogin extends Plugin
{

    public static $plugin;

    /**
     * @var string
     */
    public $schemaVersion = '1.0.7';

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register our site route
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'craft-ccb-login/default';
            }
        );

        // Register our variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('craftccblogin', CraftccbloginVariable::class);
            }
        );

/**
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
        Craft::info(
            Craft::t(
                'craft-ccb-login',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
    /**
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'craft-ccb-login/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
