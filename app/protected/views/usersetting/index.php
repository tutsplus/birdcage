<?php
$this->breadcrumbs=array(
	'User Settings',
);

$this->menu=array(
	array('label'=>'Create UserSetting','url'=>array('create')),
	array('label'=>'Manage UserSetting','url'=>array('admin')),
);
?>

<h1>User Settings</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
