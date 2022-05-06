<?php

namespace thisanimus\CCBLogin\models;

use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;

class Settings extends Model{
    /**
     *
     * @var string
     */
    public $ccbApiUser;
    public $ccbApiPassword;
    public $ccbApiUrl;

    // Public Methods
    // =========================================================================

    /**
     *
     * @return array
     */
    public function rules(): array
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