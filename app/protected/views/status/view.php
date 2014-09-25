<?php
$this->breadcrumbs=array(
	'Statuses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Status','url'=>array('index')),
	array('label'=>'Create Status','url'=>array('create')),
	array('label'=>'Update Status','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Status','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Status','url'=>array('admin')),
);
?>

<h1>View Status #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'account_id',
		'in_reply_to_status_id',
		'place_id',
		'tweet_text',
		'created_at',
		'modified_at',
	),
)); ?>
