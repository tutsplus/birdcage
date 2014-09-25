<?php
class Mailgun extends CComponent
{

	/*
	 Mailgun Library Functions
	*/	
  private function setup_curl($command = 'messages') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:'.Yii::app()->params['mailgun']['api_key']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, Yii::app()->params['mailgun']['api_url'].'/geogram.com/'.$command);  
    return $ch;   
  }
  
  public function mail($from ='support@geogram.com', $to ='',$subject='',$message='',$headers='') {
    $ch = $this->setup_curl('messages');
      curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => $from,
                                                 'to' => $to,
                                                 'subject' => $subject,
                                                 'text' => $message,
                                                 'o:tracking' => false
                                                 ));

      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
    }

    public function send_broadcast_message($from='support@geogram.com',$subject='',$body='',$recipient_list='',$recipient_vars='',$post_id=0) {
      $ch = $this->setup_curl('messages');
      curl_setopt($ch,
                  CURLOPT_POSTFIELDS,
                  array('from' => $from,
                        'to' => trim($recipient_list,','),
                        'subject' => $subject,
                        'text' => $body,
                        'recipient-variables' => $recipient_vars ,
                        'v:post_id' => $post_id)
                        );
// 'h:reply-to' => $replyTo
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
    }
  
  public function recordId($result,$id) {
    // update outbound_mail table with external id
    // returned from mailgun send
    $resp = json_decode($result);
    if (property_exists($resp,'id')) {
      OutboundMail::model()->updateAll(array( 'ext_id' => $resp->id ), 'id = '.$id );      
    }
  }
    
	public function php_mail($email ='',$subject='',$message='',$headers='') {
    $ch = $this->setup_curl('messages');
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => Yii::app()->params['supportEmail'],
                                               'to' => $email,
                                               'subject' => $subject,
                                               'text' => $message,
                                               'o:tracking' => false
                                               ));

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }
  
  public function send_simple_message($to='',$subject='',$body='',$from='') {
    if ($from == '') 
      $from = Yii::app()->params['supportEmail'];
    $ch = $this->setup_curl('messages');

    curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => $from,
                                               'to' => $to,
                                               'subject' => $subject,
                                               'text' => $body,
                                               'o:tracking' => false,
                                               ));

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }	
	
  public function send_digest_message($to='',$subject='',$body='',$from='') {	
    // to do - add html support for digest messages
    if ($from == '') 
      $from = Yii::app()->params['supportEmail'];
    $ch = $this->setup_curl('messages');

    curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => $from,
                                               'to' => $to,
                                               'subject' => $subject,
                                               'text' => $body,
                                               'o:tracking' => false,
                                               ));

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;    
  }
  
  public function listCreate($address='', $name='',$description ='') {
    $ch = $this->setup_curl('lists');
    curl_setopt($ch, CURLOPT_URL, Yii::app()->params['mailgun']['api_url'].'/lists');  
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('address' => $address.'@geogram.com',
                                                  'name'=>$name,
                                                 'description' => $description));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;    
  }
  
  public function listDelete($address='', $name='',$description ='') {
    $ch = $this->setup_curl('lists');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_URL, Yii::app()->params['mailgun']['api_url'].'/lists/'.$address.'@geogram.com');             
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;    
  }
  
  public function memberAdd($list='',$email='',$first_name='',$last_name) {
    $ch = $this->setup_curl('lists');
    curl_setopt($ch, CURLOPT_URL, Yii::app()->params['mailgun']['api_url'].'/lists/'.$list.'@geogram.com/members');  
    echo Yii::app()->params['mailgun']['api_url'].'/lists/'.$list.'@geogram.com/members';
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('address' => $email,
                                                 'name' => $first_name.' '.$last_name,
                                                 'subscribed' => true,
                                                 'upsert' => 'yes'
                                                 ));    
     $result = curl_exec($ch);
     curl_close($ch);
     return $result;    
  }
  
  public function memberUpdate($list='',$email='',$propList) {
     $ch = $this->setup_curl('lists');
     curl_setopt($ch, CURLOPT_URL, Yii::app()->params['mailgun']['api_url'].'/lists/'.$list.'@geogram.com/members/'.$email);  
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
       curl_setopt($ch, CURLOPT_POSTFIELDS, $propList);  
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;    
   }
   
   public function memberUnsubscribe($list='',$email='') {
     $propList = array('subscribed'=>false);
     $result=$this->memberUpdate($list,$email,$propList);
   }
   
     public function listAddRecentlyAdded() {
   	    $users= User::model()->ok_mail()->recently_added()->findAll();
   	  foreach ($users as $u) {
   	    echo $u->email.' '.ucwords(getUserProfile($u->id)->getAttribute('first_name')).' '.ucwords(getUserProfile($u->id)->getAttribute('last_name'));lb();	    
   $result=$this->memberAdd('all_geogram',$u->email,ucwords(getUserProfile($u->id)->getAttribute('first_name')),ucwords(getUserProfile($u->id)->getAttribute('last_name')));
   var_dump($result);
       }
   }
   
   public function verifyWebHook($timestamp='', $token='', $signature='') {
     // Concatenate timestamp and token values
     $combined=$timestamp.$token;
    //lg('Combined:'.$combined);
     // Encode the resulting string with the HMAC algorithm
     // (using your API Key as a key and SHA256 digest mode)
     $result= hash_hmac('SHA256', $combined, Yii::app()->params['mailgun']['api_key']);
     //lg ('Result: '.$result);
     //lg ('Signature: '.$signature);
     if ($result == $signature)
       return true;
      else
      return false;    
   }
   
}

?>