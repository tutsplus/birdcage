<?php

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jquery.simplyCountable.js');
$cs->registerScriptFile($baseUrl.'/js/twitter-text.js');
$cs->registerScriptFile($baseUrl.'/js/twitter_count.js');

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'status-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php 
  if(Yii::app()->user->hasFlash('no_account')
    ) {
  $this->widget('bootstrap.widgets.TbAlert', array(
      'alerts'=>array( // configurations per alert type
  	    'no_account'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
      ),
  ));
}
?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

  <?php 
    if ($model->account_id == 0 ) {
      echo CHtml::activeLabel($model,'account_id',array('label'=>'Tweet with Account:')); 
      $model->account_id = 1;
      echo CHtml::activeDropDownList($model,'account_id',Account::model()->getList(),array('empty'=>'Select an Account'));
    } else {
      echo CHtml::hiddenField('account_id',$model->account_id);
        }
  ?>

  <br />
	<?php 
	echo $form->textAreaRow($model,'tweet_text',array('id'=>'tweet_text','rows'=>6, 'cols'=>50, 'class'=>'span8'));
   ?>
   <p class="right">Remaining: <span id="counter2">0</span></p>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function()
	{
	  $('#tweet_text').simplyCountable({
	    counter: '#counter2',
      maxCount: 140,
      countDirection: 'down'
	  });
	});
</script>
