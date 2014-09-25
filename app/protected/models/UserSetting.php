<?php

/**
 * This is the model class for table "{{user_setting}}".
 *
 * The followings are the available columns in table '{{user_setting}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $twitter_key
 * @property string $twitter_secret
 * @property string $twitter_url
 * @property integer $twitter_stream
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UserSetting extends CActiveRecord
{
  const STREAM_NO = 0;
  const STREAM_YES = 10;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserSetting the static model class
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
		return '{{user_setting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('twitter_key, twitter_secret, twitter_url', 'length', 'max'=>255),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, twitter_key, twitter_secret, twitter_url, twitter_stream, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'twitter_key' => 'Twitter Key',
			'twitter_secret' => 'Twitter Secret',
			'twitter_url' => 'Twitter Url',
			'twitter_stream' => 'Twitter Stream',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('twitter_key',$this->twitter_key,true);
		$criteria->compare('twitter_secret',$this->twitter_secret,true);
		$criteria->compare('twitter_url',$this->twitter_url,true);
		$criteria->compare('twitter_stream',$this->twitter_stream);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

  public function initialize($user_id) {
    // sets up User Setting row for this user_id
    // called from activation
    if (UserSetting::model()->countByAttributes(array('user_id'=>$user_id)) == 0) {
        $us = new UserSetting();
        $us->user_id = $user_id;
        $us->twitter_key= '';
        $us->twitter_secret= '';
        $us->twitter_url= '';
        $us->twitter_stream= self::STREAM_NO;
        $us->created_at =new CDbExpression('NOW()');
        $us->modified_at =new CDbExpression('NOW()');                  
        $result = $us->save();
      }
  }	  
  
	public function checkConfiguration($user_id) {
	  if (UserSetting::model()->countByAttributes(array('user_id'=>$user_id)) == 0) {
	    return false;
    } else {
      $us=UserSetting::model()->findByAttributes(array('user_id'=>$user_id));
      if (empty($us['twitter_key']) or empty($us['twitter_secret']) or empty($us['twitter_url'])) {
        return false;
      }
    }
    return true;
	}
	
	public function loadPrimarySettings() {
	  $criteria=new CDbCriteria;
    $criteria->condition="twitter_key <> '' and twitter_secret<>'' and twitter_url<>''";
    $criteria->order = "user_id asc";
    $criteria->limit = 1;
    $row = UserSetting::model()->find($criteria);
    if (empty($row)) {
      echo 'strong>Twitter not configured in user settings</strong>';
      yexit();
    }
	  return $row;
	}
	
}