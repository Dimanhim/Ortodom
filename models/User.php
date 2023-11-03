<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $name;
    public $shortName;
    public $cellClass;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $role;

    private static $users = [
        '100' => [
            'id' => '100',
            'name' => '',
            'shortName' => '',
            'username' => 'admin',
            'password' => 'orto',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
            'cellClass' => '',
            'role' => 'admin',
        ],
        '200' => [
            'id' => '200',
            'name' => '',
            'shortName' => '',
            'username' => 'orto',
            'password' => 'ortodom',
            'authKey' => 'test200key',
            'accessToken' => '200-token',
            'cellClass' => '',
            'role' => 'superadmin',
        ],
        '300' => [
            'id' => '300',
            'name' => '',
            'shortName' => '',
            'username' => 'manager',
            'password' => 'orto',
            'authKey' => 'test300key',
            'accessToken' => '300-token',
            'cellClass' => '',
            'role' => 'manager',
        ],
        '400' => [
            'id' => '400',
            'name' => 'Саакян Лазарь Артёмович',
            'shortName' => 'Саакян Л.А.',
            'username' => 'sla',
            'password' => '1234',
            'authKey' => 'test400key',
            'accessToken' => '400-token',
            'cellClass' => 'pale-blue',
            'role' => 'admin',
        ],
        '500' => [
            'id' => '500',
            'name' => 'Устинова Мария Сергеевна',
            'shortName' => 'Устинова М.С.',
            'username' => 'ums',
            'password' => '4321',
            'authKey' => 'test500key',
            'accessToken' => '500-token',
            'cellClass' => 'pale-yellow',
            'role' => 'admin',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function getIsManager()
    {
        return \Yii::$app->user->getIdentity()->role == 'manager';
    }

    /**
     * @return bool
     */
    public function disabledAccess($controllerId)
    {
        $disallowed = [
            'manager' => [
                'patient', 'order', 'visit'
            ]
        ];
        $userRole = \Yii::$app->user->getIdentity()->role;
        if(array_key_exists($userRole, $disallowed)) {
            return !in_array($controllerId, $disallowed[$userRole]);
        }
        return false;
    }
}
