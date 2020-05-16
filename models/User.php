<?php

namespace app\models;
use yii\base\Security;
use yii\db\ActiveRecord;


//class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface

class User extends ActiveRecord implements \yii\web\IdentityInterface

{

    public static function tableName()
    {
        return 'users';
    }

    public function getRole(){
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }



    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        return static::findOne(['access_token' => $token]);
    }


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
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
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);

    }


    public function generateAuthKey(){
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }



}
