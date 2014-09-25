<?php
$this->breadcrumbs=array(
	'Streams'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Stream','url'=>array('index')),
	array('label'=>'Create Stream','url'=>array('create')),
	array('label'=>'View Stream','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Stream','url'=>array('admin')),
);
?>

<h1>Update Stream <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>