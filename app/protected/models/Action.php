<?php

/**
 * This is the model class for table "{{action}}".
 *
 * The followings are the available columns in table '{{action}}':
 * @property integer $id
 * @property integer $account_id
 * @property integer $action
 * @property string $last_tweet_id
 * @property string $last_checked
 * @property integer $status
 * @property string $created_at
 * @property string $modified_at
 */
class Action extends CActiveRecord
{
  const ACTION_HISTORY = 10;
  const ACTION_DELETE = 20;
  const STATUS_ACTIVE = 10;
  const STATUS_COMPLETE = 20;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Action the static model class
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
		return '{{action}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('last_tweet_id, modified_at', 'required'),
			array('account_id, action, status', 'numerical', 'integerOnly'=>true),
			array('last_tweet_id', 'length', 'max'=>20),
			array('last_checked, created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, account_id, action, last_tweet_id, last_checked, status, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'action' => 'Action',
			'last_tweet_id' => 'Last Tweet',
			'last_checked' => 'Last Checked',
			'status' => 'Status',
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
		$criteria->compare('action',$this->action);
		$criteria->compare('last_tweet_id',$this->last_tweet_id,true);
		$criteria->compare('last_checked',$this->last_checked,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function requestHistory($account_id) {
	  $a = new Action;
	  $a->account_id = $account_id;
	  $a->action = self::ACTION_HISTORY;
	  $a->status = self::STATUS_ACTIVE;
    $a->created_at = date( 'Y-m-d H:i:s', strtotime($tweet->created_at) );
    $a->modified_at =new CDbExpression('NOW()');          
	  $a->save;
	}
	
	public function processActions() {
    $adv= new Advanced;
    $adv->destroy(1, 479705735316525056);
yexit();
	  
	  $todo = Action::model()->findAllByAttributes(array('status'=>self::STATUS_ACTIVE));
	  foreach ($todo as $item) {
	    if ($item->action == self::ACTION_HISTORY) {
	      $adv->getHistory($item);
	    }
	  }
	}
}