<?php
$this->breadcrumbs=array(
	'User Settings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

// display flash if came from content tests
if(Yii::app()->user->hasFlash('warning')) {
  $this->widget('bootstrap.widgets.TbAlert', array(
      'block'=>true, // display a larger alert block?
      'fade'=>true, // use transitions?
      'closeText'=>'×', // close link text - if set to false, no close link is displayed
      'alerts'=>array( // configurations per alert type
  	    'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
      ),
  ));
}


?>

<h1>Update Your Settings</h1>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>