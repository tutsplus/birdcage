<?php

/**
 * This is the model class for table "{{stream}}".
 *
 * The followings are the available columns in table '{{stream}}':
 * @property integer $id
 * @property string $tweet_id
 * @property string $code
 * @property integer $is_processed
 * @property string $created_at
 * @property string $modified_at
 */
class Stream extends CActiveRecord
{
  const STREAM_NEW = 0;
  const STREAM_PROCESSED = 10;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Stream the static model class
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
		return '{{stream}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tweet_id, modified_at', 'required'),
			array('is_processed', 'numerical', 'integerOnly'=>true),
			array('tweet_id', 'length', 'max'=>20),
			array('code, created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tweet_id, code, is_processed, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'tweet_id' => 'Tweet',
			'code' => 'Code',
			'is_processed' => 'Is Processed',
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
		$criteria->compare('tweet_id',$this->tweet_id,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('is_processed',$this->is_processed);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function process() {
	  // get unprocessed tweets from stream engine
	  // to do 
	  $account_id = 1;
	  $items = Stream::model()->unprocessed()->findAll();
	  foreach ($items as $i) {
	    $tweet = unserialize(base64_decode($i['code']));
      Tweet::model()->parse($account_id,$tweet);
      $this->setStatus($i['id'],self::STREAM_PROCESSED);      
	  }
	}
	
	public function setStatus($id,$status) {
	  $ns = Stream::model()->findByPK($id);
	  $ns->is_processed = $status;
	  $ns->save();
	}
	
  // scoping functions
  public function scopes()
      {
          return array(   
              'unprocessed'=>array(
                  'condition'=>'is_processed='.self::STREAM_NEW, 
              ),
          );
      }		
  

	
}