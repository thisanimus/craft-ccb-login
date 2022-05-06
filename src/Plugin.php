<?php
/**
 * test plugin for Craft CMS 3.x
 *
 * Test
 *
 * @link      https://github.com/gustavs-gutmanis
 * @copyright Copyright (c) 2020 Gustavs Gutmanis
 */

namespace thisanimus\CCBLogin;

use thisanimus\CCBLogin\variables\Variables;
use thisanimus\CCBLogin\models\Settings;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\base\Model;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Test
 *
 * @author    Gustavs Gutmanis
 * @package   Test
 * @since     1.0.0
 *
 */
class Plugin extends BasePlugin
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Register our site route
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'ccb-login/default';
            }
        );

        // Register our variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('craftccblogin', Variables::class);
                $variable->set('ccblogin', Variables::class);
            }
        );

        Craft::info('CCB Login Loaded', __METHOD__);
    }
    /**
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }
    /**
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate(
            'ccb-login/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
