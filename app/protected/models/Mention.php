<?php

/**
 * This is the model class for table "{{mention}}".
 *
 * The followings are the available columns in table '{{mention}}':
 * @property integer $id
 * @property string $tweet_id
 * @property string $source_user_id
 * @property string $target_user_id
 *
 * The followings are the available model relations:
 * @property Tweet $tweet
 */
class Mention extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mention the static model class
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
		return '{{mention}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tweet_id, source_user_id, target_user_id', 'required'),
			array('tweet_id, source_user_id, target_user_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tweet_id, source_user_id, target_user_id', 'safe', 'on'=>'search'),
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
			'tweet' => array(self::BELONGS_TO, 'Tweet', 'tweet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tweet_id' => 'Tweet',
			'source_user_id' => 'Source User',
			'target_user_id' => 'Target User',
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
		$criteria->compare('tweet_id',$this->tweet_id,true);
		$criteria->compare('source_user_id',$this->source_user_id,true);
		$criteria->compare('target_user_id',$this->target_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function add($tweet_id,$source_user_id,$target_user_id) {
    $mention = Mention::model()->findByAttributes(array('tweet_id'=>$tweet_id,'source_user_id'=>$source_user_id,'target_user_id'=>$target_user_id));
    if (empty($mention)) {
  	  $mention = new Mention;
  	  $mention->tweet_id = $tweet_id;
  	  $mention->source_user_id = $source_user_id;
  	  $mention->target_user_id = $target_user_id;
      $mention->save();
    }
    return $mention;
  }  
	
}