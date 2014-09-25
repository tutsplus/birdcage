<?php
$this->breadcrumbs=array(
	'Tweets'=>array('index'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List Tweet','url'=>array('index')),
	array('label'=>'Manage Tweet','url'=>array('admin')),
);
*/
?>

<h1>Compose a Tweet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>