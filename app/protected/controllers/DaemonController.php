
<?php

class DaemonController extends Controller
{

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
		return array (
			array('allow',  // allow all users to perform 'receive' action
				'actions'=>array('index','process'),
				'users'=>array('*'),
			),		
			array('allow', // allow admin user to perform 'admin' actions
				'actions'=>array('admin','reset'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex() {
	  // if not using twitter streams, we'll process tweets by REST API
	  if (!Yii::app()->params['twitter_stream']) {
	    Tweet::model()->getStreams();	    
	  } else {
	    Stream::model()->process();
	  }
  }

  public function actionProcess() {
    // process Actions
    Action::model()->processActions();
	  }

 
 public function actionReset() {
   Tweet::model()->reset();
 }
}
