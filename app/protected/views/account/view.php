<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Account','url'=>array('index')),
	array('label'=>'Create Account','url'=>array('create')),
	array('label'=>'Update Account','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Account','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Account','url'=>array('admin')),
);
?>

<h1>View Account #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'screen_name',
		'oauth_token',
		'oauth_token_secret',
		'last_checked',
		'created_at',
		'modified_at',
	),
)); ?>
