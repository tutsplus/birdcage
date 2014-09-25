
<?php

class MailgunController extends Controller
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
				'actions'=>array('receive'),
				'users'=>array('*'),
			),		
			array('allow', // allow admin user to perform 'admin' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
		
	/* Receives posted form from Mailgun with inbound commands
	  Places data into inbox table
	*/
	public function actionReceive()
	{	  
    $mg = new Mailgun;
     // verify post made by Mailgun
      if ($mg->verifyWebHook($_POST['timestamp'],$_POST['token'],$_POST['signature'])) {
    	  $bundle = serialize($_POST);
    	  $inboxItem = new Inbox;
    	  $inboxItem->addBundle($bundle);
      }	    
	}
		
}
