<?php
$this->breadcrumbs=array(
	'Streams',
);

$this->menu=array(
	array('label'=>'Create Stream','url'=>array('create')),
	array('label'=>'Manage Stream','url'=>array('admin')),
);
?>

<h1>Streams</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
