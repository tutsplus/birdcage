<?php

/**
 * This is the model class for table "{{tweet}}".
 *
 * The followings are the available columns in table '{{tweet}}':
 * @property integer $id
  * @property integer $account_id
 * @property string $twitter_user_id
 * @property string $last_checked
 * @property string $tweet_id
 * @property string $tweet_text
 * @property integer $is_rt
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Hashtag[] $hashtags
 * @property Mention[] $mentions
 * @property Account $account
 * @property TwitterUser $twitterUser
 * @property Url[] $urls
 */
 
class Tweet extends CActiveRecord
{
  public $max_tweet_id;
  public $min_tweet_id;
  public $cnt;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tweet the static model class
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
		return '{{tweet}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('twitter_user_id, tweet_id, tweet_text, modified_at', 'required'),
			array('account_id,is_rt', 'numerical', 'integerOnly'=>true),
			array('twitter_user_id, tweet_id', 'length', 'max'=>20),
			array('last_checked, created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, twitter_user_id, last_checked, tweet_id, tweet_text, account_id, is_rt, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'hashtags' => array(self::HAS_MANY, 'Hashtag', 'tweet_id'),
			'mentions' => array(self::HAS_MANY, 'Mention', 'tweet_id'),
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'twitterUser' => array(self::BELONGS_TO, 'TwitterUser', 'twitter_user_id'),
			'urls' => array(self::HAS_MANY, 'Url', 'tweet_id'),		  
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
			'twitter_user_id' => 'Twitter User',
			'last_checked' => 'Last Checked',
			'tweet_id' => 'Tweet',
			'tweet_text' => 'Tweet Text',
			'screen_name' => 'Screen Name',
			'name' => 'Name',
			'profile_image_url' => 'Profile Image Url',
			'is_rt' => 'Is Rt',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
		);
	}

  public function add($account_id,$tweet) {
    $nt = Tweet::model()->findByAttributes(array('tweet_id'=>$tweet->id_str));
    if (empty($nt)) {
  	  $nt = new Tweet;
  	  $nt->account_id = $account_id;
  	  $nt->twitter_user_id = $tweet->user->id_str;
      $nt->tweet_id= $tweet->id_str;
      $nt->tweet_text= $tweet->text;
      if (isset($tweet->retweeted_status))
        $nt->is_rt = 1;
      $nt->created_at = date( 'Y-m-d H:i:s', strtotime($tweet->created_at) );
      $nt->modified_at =new CDbExpression('NOW()');          
      $nt->save();
    }
    return $nt;
  }
  
  public function getLastTweet($account_id) {
    // get highest tweet_it where account_id = $account_id
    $criteria=new CDbCriteria;
    $criteria->select='max(tweet_id) AS max_tweet_id';
    $criteria->condition="account_id = ".$account_id;
    $row = Tweet::model()->find($criteria);
    if ($row['max_tweet_id'] ==0)
      return 1;
    else
      return $row['max_tweet_id']+1;
  }

  public function getUserStats($account_id) {
    $criteria=new CDbCriteria;
    $criteria->select='count(tweet_id) as cnt, max(tweet_id) as max_tweet_id,min(tweet_id) as min_tweet_id';
    $criteria->condition="account_id = ".$account_id;
    $results = Tweet::model()->find($criteria);
    return $results;
  }

  public function getAccountStats($account_id) {
    $criteria=new CDbCriteria;
    $criteria->select='count(tweet_id) as cnt, max(tweet_id) as max_tweet_id,min(tweet_id) as min_tweet_id';
    $criteria->condition="account_id = ".$account_id;
    $results = Tweet::model()->find($criteria);
    return $results;
  }
  
  public function getStreams() {
    $users = User::model()->findAll();
    foreach ($users as $user) {
      $user_id = $user['id'];
      echo 'User: '.$user['username'];lb();
      $accounts = Account::model()->findAllByAttributes(array('user_id'=>$user_id));
      foreach ($accounts as $account) {
        $account_id = $account['id'];  
        echo 'Account: '.$account['screen_name'];lb();
        //get user details
        /*
        $vc= $twitter->get("account/verify_credentials");
        var_dump($vc);lb();
        if (count($vc->errors)>0) {
          echo 'Errors';
          yexit();
        }
        // to do - check if credentials invalid        
        */
        // search for recent tweets with a count
        $this->getRecentTweets($account);        
      } // end account loop
    } // end user loop
  }
  
  public function getRecentTweets($account,$limit = 200) {
    $count_tweets=0;
    // authenticate with twitter
    $twitter = Yii::app()->twitter->getTwitterTokened($account['oauth_token'], $account['oauth_token_secret']);
    // get highest previously retrieved tweet 
    $since_id = $this->getLastTweet($account->id);
    echo 'since: '.$since_id;lb();
    // retrieve tweets up until that last stored one
    $tweets= $twitter->get("statuses/home_timeline",array('count'=>100,'since_id'=>$since_id)); 
    if (count($tweets)==0) return false; // nothing returned
    if ($this->isRateLimited($tweets)) return false;
    $low_id = 0;
    $count_tweets+=count($tweets);
    echo 'count'.count($tweets);lb();
    foreach ($tweets as $i) {
      if ($low_id==0)
        $low_id = intval($i->id_str);
      else
        $low_id = min(intval($i->id_str),$low_id);
      Tweet::model()->parse($account->id,$i);
    }
    // retrieve next block until our code limit reached
    while ($count_tweets <= $limit) {
      lb(2);
      // to do - max id look at since id as well
      $max_id = $low_id-1;
      $tweets= $twitter->get("statuses/home_timeline",array('count'=>100,'max_id'=>$max_id,'since_id'=>$since_id));
      if (count($tweets)==0) break;
      if ($this->isRateLimited($tweets)) return false;
      echo 'count'.count($tweets);lb();
      $count_tweets+=count($tweets);
      foreach ($tweets as $i) {
        $low_id = min(intval($i->id_str),$low_id);
        Tweet::model()->parse($account->id,$i);
      }              
    }
  }
  
  public function getUserTweets($account, $max_id = 0, $limit = 200) {
    $count_tweets=0;
    // authenticate with twitter
    $twitter = Yii::app()->twitter->getTwitterTokened($account['oauth_token'], $account['oauth_token_secret']);
    if ($max_id == 0) {
      // get highest previously retrieved tweet 
        $max_id = $this->getLastTweet($account->id);      
    }
    // retrieve tweets up until that last stored one
    if ($max_id == 0)
      $tweets= $twitter->get("statuses/user_timeline",array('count'=>100)); 
    else
      $tweets= $twitter->get("statuses/user_timeline",array('count'=>100,'max_id'=>$max_id)); 
    if (count($tweets)==0) {
      return $max_id; // return prior max tweet
    }
    if ($this->isRateLimited($tweets)) return false;
    $low_id = 0;
    $count_tweets+=count($tweets);
    echo 'count'.count($tweets);lb();
    foreach ($tweets as $i) {
      if ($low_id==0)
        $low_id = intval($i->id_str);
      else
        $low_id = min(intval($i->id_str),$low_id);
      Tweet::model()->parse($account->id,$i);
    }
    // retrieve next block until our code limit reached
    while ($count_tweets <= $limit) {
      lb(2);
      $max_id = $low_id-1;
      $tweets= $twitter->get("statuses/user_timeline",array('count'=>100,'max_id'=>$max_id));
      if (count($tweets)==0 or $this->isRateLimited($tweets)) return $max_id;
      echo 'count'.count($tweets);lb();
      $count_tweets+=count($tweets);
      foreach ($tweets as $i) {
        $low_id = min(intval($i->id_str),$low_id);
        Tweet::model()->parse($account->id,$i);
      }              
    }
  }
  
  public function parse($account_id,$tweet) {
      // add user
      $tu = TwitterUser::model()->add($tweet->user);
      // add tweet
      $tweet_obj = $this->add($account_id,$tweet);
      echo 'Tweet_id'.$tweet->id_str;
  echo $tu->name;
  echo '<img src="'.$tu->profile_image_url.'">';lb();
  lb();
	if (isset($tweet->retweeted_status)) {
    // source tweet entities
    $entities = $tweet->retweeted_status->entities;        
		$is_rt = 1;
  } else {
 	  $entities = $tweet->entities;
	  $is_rt = 0;
  }
    
      // Parse the urls, mentions and hashtags
      if (isset($entities->user_mentions)) {
          foreach ($entities->user_mentions as $mention) {

        /*        
          add mention
          $field_values = 'tweet_id=' . $tweet_id . ', ' .
                  'source_user_id=' . $user_id . ', ' .
                  'target_user_id=' . $user_mention->id;	

        */
          echo 'mention: '.$mention->id;lb();
          // add the mention if new
          Mention::model()->add($tweet->id_str,$tweet->user->id_str,$mention->id_str);
          }
      }
      if (isset($entities->hashtags)) {
          foreach ($entities->hashtags as $hashtag) {
                // add hashtag
        //          $field_values = 'tweet_id=' . $tweet_id . ', ' .
        //            'tag="' . $hashtag->text . '"';	
        echo 'hashtag: '.$hashtag->text;lb();
        // add the hashtag if new
         Hashtag::model()->add($tweet->id_str,$hashtag->text);
          }        
      }
      if (isset($entities->urls)) {
        foreach ($entities->urls as $url) {
          if (empty($url->expanded_url)) {
            $url = $url->url;
          } else {
            $url = $url->expanded_url;
          }
          // add url
          echo 'url: '.$url;lb();
          // add the url if new
          Url::model()->add($tweet->id_str,$url);
          }
        }    
        echo '========';lb();
  }
  
  public function isRateLimited($tweets) {
    if (empty($tweets) || !isset($tweets->errors)) return false;
    if (count($tweets->errors)==0) return false;
    echo "Error: ";
    print_r($tweets->errors);
    return true;    
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
		$criteria->compare('twitter_user_id',$this->twitter_user_id,true);
		$criteria->compare('last_checked',$this->last_checked,true);
		$criteria->compare('tweet_id',$this->tweet_id,true);
		$criteria->compare('tweet_text',$this->tweet_text,true);
		$criteria->compare('is_rt',$this->is_rt);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function reset() {
	  Tweet::model()->deleteAll("id>0");
	  TwitterUser::model()->deleteAll("id>0");
	  ProfileUrl::model()->deleteAll("id>0");
	}
}