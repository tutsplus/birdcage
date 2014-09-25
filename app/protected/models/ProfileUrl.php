<?php

/**
 * This is the model class for table "{{profile_url}}".
 *
 * The followings are the available columns in table '{{profile_url}}':
 * @property integer $id
 * @property string $twitter_user_id
 * @property string $url
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property TwitterUser $twitterUser
 */
class ProfileUrl extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfileUrl the static model class
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
		return '{{profile_url}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('twitter_user_id, modified_at', 'required'),
			array('twitter_user_id', 'length', 'max'=>20),
			array('url', 'length', 'max'=>255),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, twitter_user_id, url, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'twitterUser' => array(self::BELONGS_TO, 'TwitterUser', 'twitter_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'twitter_user_id' => 'Twitter User',
			'url' => 'Url',
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
		$criteria->compare('twitter_user_id',$this->twitter_user_id,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function add($twitter_user_id,$url='') {
    $u = Url::model()->findByAttributes(array('twitter_user_id'=>$twitter_user_id,'url'=>$url));
    if (empty($u)) {
  	  $u = new ProfileUrl;
  	  $u->twitter_user_id = $twitter_user_id;
  	  $u->url = $url;
      $u->save();
    }
    return $u;
  }
	
}