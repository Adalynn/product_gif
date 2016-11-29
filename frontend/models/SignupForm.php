<?php
namespace frontend\models;

use Yii;

use yii\base\Model;

use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
	public $is_subscribed = false;
	public $role;
	public $status;
	public $password_reset_token;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
		
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
		$user->password = md5($this->password);
		
		$array_post['email'] = $this->email;
		$array_post['username'] = $this->username;
		$array_post['password'] = md5($this->password);
		$array_post['password_hash'] = $user->password_hash;
		$array_post['auth_key'] = $user->auth_key;
		$array_post['role'] =  (int) $this->role;
		$array_post['status'] =  (int) $this->status;
		$array_post['is_subscribed'] = $this->is_subscribed;
		$array_post['password_reset_token'] = $this->password_reset_token;
		
		//$array_post['first_name'] = $this->first_name;
		//$array_post['last_name'] = $this->last_name;


		$request = Yii::$app->db->createCommand()->insert('{{%user}}', [
			'email' => $array_post['email'],
			'username' => $array_post['username'],
			'password' => $array_post['password'],
			'password_hash' => $array_post['password_hash'],
			'password_reset_token' => $array_post['password_reset_token'],
			'auth_key' => $array_post['auth_key'],
			'role' => $array_post['role'],
			'status'=> $array_post['status'],
			'is_subscribed' =>  $array_post['is_subscribed'],
			'created_at' => time(),
			'updated_at' => time(),
		])->execute();

        if($request) {
			$insert_id = Yii::$app->db->getLastInsertID();
			// @TODO : Save user meta here the return
			//$user
			$new_user = new User();
			return Yii::$app->user->login($new_user::findByUsername($this->username));
		}
			
		// @TODO : Send email with password reset link ans stop savinf the password from here
		
		return null;
    }
	
	

}
