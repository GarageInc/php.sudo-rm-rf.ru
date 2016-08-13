<?php

namespace app\models;

use yii\base\NotSupportedException;
use Yii;

/**
 * @property string token
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
//    public $id;
//    public $username;
//    public $password;
//    public $auth_key;
//    public $token;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'auth_key', 'token'], 'required'],
            [['username', 'password', 'auth_key', 'token'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'token' => 'Token',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    public function getAuthKey()
    {
        return $this->authKey;
    }
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getGraphs()
    {
        return $this->hasMany(Graphs::className(), ['user_id' => 'id']);
    }
}