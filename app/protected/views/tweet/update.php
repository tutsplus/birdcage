<?php
$this->breadcrumbs=array(
	'Tweets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tweet','url'=>array('index')),
	array('label'=>'Create Tweet','url'=>array('create')),
	array('label'=>'View Tweet','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Tweet','url'=>array('admin')),
);
?>

<h1>Update Tweet <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>