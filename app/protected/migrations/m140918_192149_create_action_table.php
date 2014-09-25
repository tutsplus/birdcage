<?php

class m140918_192149_create_action_table extends CDbMigration
{
   protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
   public $tablePrefix;
   public $tableName;

   public function before() {
     $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
     if ($this->tablePrefix <> '')
       $this->tableName = $this->tablePrefix.'action';
   }

 	public function safeUp()
 	{
 	  $this->before();
  $this->createTable($this->tableName, array(
             'id' => 'pk',
             'account_id' => 'integer default 0',
             'action' => 'TINYINT DEFAULT 0',
             'last_tweet_id'=>'bigint(20) unsigned NOT NULL',
             'last_checked' => 'TIMESTAMP DEFAULT 0',
             'status' => 'tinyint default 0',
             'created_at' => 'DATETIME NOT NULL DEFAULT 0',
             'modified_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
               ), $this->MySqlOptions);
 	}

 	public function safeDown()
 	{
 	  	$this->before();
 	    $this->dropTable($this->tableName);
 	}
}