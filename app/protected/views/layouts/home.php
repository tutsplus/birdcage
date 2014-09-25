
<?php /* @var $this Controller */ 
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/home.js');
if (Yii::app()->params['env']=='live') {    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/statcounter.js');  
} 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/main.js'); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
  <link rel="icon" type="image/gif" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.gif" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/home.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" >
  
	<?php echo $content; 	?>

  <div class="footer" >
    <ul class="inline">
      <li> <a href="http://code.tutsplus.com/tutorials/building-with-the-twitter-api-getting-started--cms-22192">About</a><span class="dot divider"> &middot;</span></li>
      <li ><a href="/contact">Help</a><span class="dot divider"> &middot;</span></li>
<!--       <li ><a href="/privacy">Privacy</a><span class="dot divider"> &middot;</span></li> -->
      <li ><span class="copyright">&copy; 2014 Lookahead Consulting</span></li>
    </ul>
  </div>
</div><!-- page -->
</body>
</html>
