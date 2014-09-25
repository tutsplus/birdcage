<?php

/**
 * This is the model class for table "{{status}}".
 *
 * The followings are the available columns in table '{{status}}':
 * @property integer $id
 * @property integer $account_id
 * @property string $in_reply_to_status_id
 * @property integer $place_id
 * @property string $tweet_text
 * @property string $created_at
 * @property string $modified_at
 */
class Status extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Status the static model class
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
		return '{{status}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id,tweet_text', 'required'),
			array('account_id, place_id', 'numerical', 'integerOnly'=>true),
			array('in_reply_to_status_id', 'length', 'max'=>20),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, account_id, in_reply_to_status_id, place_id, tweet_text, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'account_id' => 'Account',
			'in_reply_to_status_id' => 'In Reply To Status',
			'place_id' => 'Place',
			'tweet_text' => 'Tweet Text',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('in_reply_to_status_id',$this->in_reply_to_status_id,true);
		$criteria->compare('place_id',$this->place_id);
		$criteria->compare('tweet_text',$this->tweet_text,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}