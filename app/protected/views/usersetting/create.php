<?php
$this->breadcrumbs=array(
	'User Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserSetting','url'=>array('index')),
	array('label'=>'Manage UserSetting','url'=>array('admin')),
);
?>

<h1>Create UserSetting</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>