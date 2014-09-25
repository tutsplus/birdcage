<?php
  class Consumer extends OauthPhirehose
  {
    // This function is called automatically by the Phirehose class
    // when a new tweet is received with the JSON data in $status
    public function enqueueStatus($status) {
      $stream_item = json_decode($status);
      if (!(isset($stream_item->id_str))) { return;}
      $s = new Stream;
      $s->tweet_id = $stream_item->id_str;
      $s->code = base64_encode(serialize($stream_item));
      $s->is_processed=0;
      $s->created_at = new CDbExpression('NOW()');          
      $s->modified_at =new CDbExpression('NOW()');          
      $s->save();
      var_dump($stream_item);
    }
  }
  ?>
