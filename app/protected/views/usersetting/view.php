<?php
$this->breadcrumbs=array(
	'User Settings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserSetting','url'=>array('index')),
	array('label'=>'Create UserSetting','url'=>array('create')),
	array('label'=>'Update UserSetting','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete UserSetting','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserSetting','url'=>array('admin')),
);
?>

<h1>View UserSetting #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'twitter_key',
		'twitter_secret',
		'twitter_url',
		'twitter_stream',
		'created_at',
		'modified_at',
	),
)); ?>
