<?php

class m140912_022006_create_hashtag_table extends CDbMigration
{
   protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
   public $tablePrefix;
   public $tableName;

   public function before() {
     $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
     if ($this->tablePrefix <> '')
       $this->tableName = $this->tablePrefix.'hashtag';
   }

 	public function safeUp()
 	{
 	  $this->before();
    $this->createTable($this->tableName, array(
             'id' => 'pk',
             'tweet_id' => 'BIGINT(20) unsigned NOT NULL',
             'tag'=>'string NOT NULL',
               ), $this->MySqlOptions);
              $this->addForeignKey('fk_hashtag_tweet', $this->tableName, 'tweet_id', $this->tablePrefix.'tweet', 'tweet_id', 'CASCADE', 'CASCADE');

              	}

              	public function safeDown()
              	{
              	  	$this->before();
              	  	$this->dropForeignKey('fk_hashtag_tweet', $this->tableName);  	
              	    $this->dropTable($this->tableName);
              	}
}