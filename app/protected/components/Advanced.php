<?php

class Advanced extends CComponent
{
  
  public function getHistory($action,$limit = 1000) {
    // collect next $limit tweets by user
    // show data for the user
    $stats = Tweet::model()->getAccountStats($action->account_id);
    echo $stats->cnt;
    echo $stats->min_tweet_id;
    echo $stats->max_tweet_id;
    // if last tweet is 0, start at beginning
    if ($action->last_tweet_id==0) {
      // start with a count
    } else {
          //
    }
    $account = Account::model()->findByPK($action->account_id);
    Tweet::model()->getUserTweets($account, 497762419532627968 , 500);
    
    // $action->status=Action::STATUS_COMPLETE;
    // set lowest tweet
    //$action->last_tweet_id = $low_id;
    //$action->modified_at =new CDbExpression('NOW()');          
    //$action->save();
  }
  
  public function destroy($account_id,$tweet_id) {
    $account = Account::model()->findByPK($account_id);
    $twitter = Yii::app()->twitter->getTwitterTokened($account['oauth_token'], $account['oauth_token_secret']);
    $result = $twitter->post("statuses/destroy/".$tweet_id,array()); 
    var_dump($result);
  }
  
  public function deleteTweets($account_id) {
    // back to 4000
    $limit = 4000;
    $stats = Tweet::model()->getAccountStats($action->account_id);
    echo $stats->cnt;
    // tweets to delete
    $cnt = $stats->cnt - $limit;
    if ($cnt <0) return;
    // fetch earliest tweets tweet_id ASC LIMIT $cnt
    // delete those    
  }
}

?>