<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitter_key')); ?>:</b>
	<?php echo CHtml::encode($data->twitter_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitter_secret')); ?>:</b>
	<?php echo CHtml::encode($data->twitter_secret); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitter_url')); ?>:</b>
	<?php echo CHtml::encode($data->twitter_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitter_stream')); ?>:</b>
	<?php echo CHtml::encode($data->twitter_stream); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />

	*/ ?>

</div>