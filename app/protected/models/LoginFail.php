<?php

/**
 * This is the model class for table "{{login_fail}}".
 *
 * The followings are the available columns in table '{{login_fail}}':
 * @property integer $id
 * @property string $ip_address
 * @property string $username
 * @property string $created_at
 */
class LoginFail extends CActiveRecord
{
  const FAILS_USERNAME_HOUR = 6;
  const FAILS_USERNAME_QUARTER_HOUR = 3;
  const FAILS_IP_HOUR = 24;
  const FAILS_IP_QUARTER_HOUR = 12;
  
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoginFail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{login_fail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip_address, username, created_at', 'required'),
			array('ip_address, username', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ip_address, username, created_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ip_address' => 'Ip Address',
			'username' => 'Username',
			'created_at' => 'Created At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

  public function check($username) {
    // check if failed login threshold has been violated
    // for username in last 15 minutes and last hour
    // and for IP address in last 15 minutes and last hour
    $has_error = false;
    $minutes_ago = (time() - (60*15));  // 15 minutes ago
    $hours_ago = (time() - (60*60));  // 1 hour ago
    $user_ip = $this->getUserIP();
    if (LoginFail::model()->since($minutes_ago)->username($username)->count()>=self::FAILS_USERNAME_QUARTER_HOUR) {
      $has_error = true;
    } else if (LoginFail::model()->since($minutes_ago)->ip_address($user_ip)->count()>=self::FAILS_IP_QUARTER_HOUR) {
        $has_error = true;
      } else if (LoginFail::model()->since($hours_ago)->username($username)->count()>=self::FAILS_USERNAME_HOUR) {
      $has_error = true;
    } else if (LoginFail::model()->since($hours_ago)->ip_address($user_ip)->count()>=self::FAILS_IP_HOUR) {
        $has_error = true;
      }
      if ($has_error)
      	$this->add($username);			
      return $has_error;
  }

  public function add($username) {
    // add a row to the failed login table with username and IP address
    $failure = new LoginFail;
    $failure->username = $username;
    $failure->ip_address = $this->getUserIP();
    $failure->created_at =new CDbExpression('NOW()'); 
    $failure->save();
    // whenever there is a failed login, purge older failure log
    $this->purge();
  }

  public function purge($mins=120) {
    // purge failed login entries older than $mins
    $minutes_ago = (time() - (60*$mins));  // e.g. 120 minutes ago
    $criteria=new CDbCriteria();
    LoginFail::model()->older_than($minutes_ago)->applyScopes($criteria);
    LoginFail::model()->deleteAll($criteria);    
  }
  
  public function getUserIP()
  {
      // via http://stackoverflow.com/questions/11864059/how-to-get-ip-address-in-php
      $client  = @$_SERVER['HTTP_CLIENT_IP'];
      $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
      $remote  = $_SERVER['REMOTE_ADDR'];

      if(filter_var($client, FILTER_VALIDATE_IP))
      {
          $ip = $client;
      }
      elseif(filter_var($forward, FILTER_VALIDATE_IP))
      {
          $ip = $forward;
      }
      else
      {
          $ip = $remote;
      }
      return $ip;
  }
  
  
  // scoping functions

    // scope of rows since timestamp
  public function since($tstamp=0)
  {
    $this->getDbCriteria()->mergeWith( array(
      'condition'=>'(UNIX_TIMESTAMP(created_at)>'.$tstamp.')',
    ));
      return $this;
  }

  // scope of rows before timestamp
  public function older_than($tstamp=0)
  {
    $this->getDbCriteria()->mergeWith( array(
      'condition'=>'(UNIX_TIMESTAMP(created_at)<'.$tstamp.')',
    ));
      return $this;
  }

  public function username($username='')
  {
    $this->getDbCriteria()->mergeWith( array(
      'condition'=>'(username="'.$username.'")',
    ));
      return $this;
  }

  public function ip_address($ip_address='')
  {
    $this->getDbCriteria()->mergeWith( array(
      'condition'=>'(ip_address="'.$ip_address.'")',
    ));
      return $this;
  }

}