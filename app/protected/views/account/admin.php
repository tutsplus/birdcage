<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Account','url'=>array('index')),
	array('label'=>'Add a Twitter Account','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('account-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Your Twitter Accounts</h1>

<?php 

if (Yii::app()->user->hasFlash('upgrade')) {
  $this->widget('bootstrap.widgets.TbAlert', array(
      'block'=>true, // display a larger alert block?
      'fade'=>true, // use transitions?
      'closeText'=>'×', // close link text - if set to false, no close link is displayed
      'alerts'=>array( // configurations per alert type
  	    'upgrade'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
      ),
  ));
  
}

?>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'account-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'screen_name',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
    'htmlOptions'=>array('width'=>'100px'),  		
  	'class'=>'bootstrap.widgets.TbButtonColumn',
  	'header'=>'Options',
    'template'=>'{connect}{delete}', // '{delete}'
        'buttons'=>array
        (
            'connect' => array
            (
            'options'=>array('title'=>'authenticate'),
              'label'=>'<i class="icon-twitter icon-large" style="margin:5px;"></i>',
              'url'=>'Yii::app()->createUrl("twitter/connect", array("id"=>$data->id))',
            ),        
            'delete' => array
            (
            'options'=>array('title'=>'trash'),
              'label'=>'<i class="icon-trash icon-large" style="margin:5px;"></i>',
              'url'=>'Yii::app()->createUrl("message/delete", array("id"=>$data->id))',
            ),
        ),			
  ),
	),
)); ?>
