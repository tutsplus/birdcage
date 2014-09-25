<?php

class TwitterController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','callback','connect'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  public function actionIndex() {
    echo 'index';
  }

  public function actionConnect()
       {
        unset(Yii::app()->session['account_id']);
        Yii::app()->session['account_id']=$_GET['id'];
       $twitter = Yii::app()->twitter->getTwitter();  
       $request_token = $twitter->getRequestToken();
       //set some session info
       Yii::app()->session['oauth_token'] = $token =$request_token['oauth_token'];
       Yii::app()->session['oauth_token_secret'] = $request_token['oauth_token_secret'];

          if ($twitter->http_code == 200) {
              //get twitter connect url
              $url = $twitter->getAuthorizeURL($token);
              //send them              
              Yii::app()->request->redirect($url);
          }else{
              //error here
              $this->redirect(Yii::app()->homeUrl);
          }
      }
    
  public function actionCallback() {
    /* If the oauth_token is old redirect to the connect page. */
            if (isset($_REQUEST['oauth_token']) && Yii::app()->session['oauth_token'] !== $_REQUEST['oauth_token']) {
                Yii::app()->session['oauth_status'] = 'oldtoken';
            }
/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
            $twitter = Yii::app()->twitter->getTwitterTokened(Yii::app()->session['oauth_token'], Yii::app()->session['oauth_token_secret']);   
            /* Request access tokens from twitter */
            $access_token = $twitter->getAccessToken($_REQUEST['oauth_verifier']);
      /* Save the access tokens. Normally these would be saved in a database for future use. */            
            Yii::app()->session['access_token'] = $access_token;
            $account = Account::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'id'=>Yii::app()->session['account_id']));
            $account['oauth_token'] = $access_token['oauth_token'];
            $account['oauth_token_secret'] = $access_token['oauth_token_secret'];
$account->save();
            
            /* Remove no longer needed request tokens */
            unset(Yii::app()->session['oauth_token']);
            unset(Yii::app()->session['oauth_token_secret']);

            if (200 == $twitter->http_code) {
          /* The user has been verified and the access tokens can be saved for future use */
                Yii::app()->session['status'] = 'verified';
                $this->redirect(array('account/admin'));

            } else {
                /* Save HTTP status for error dialog on connnect page.*/
                //header('Location: /clearsessions.php');
                $this->redirect(Yii::app()->homeUrl);
            } 
       }
}
