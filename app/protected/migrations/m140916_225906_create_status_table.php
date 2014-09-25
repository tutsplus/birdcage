<?php

class m140916_225906_create_status_table extends CDbMigration
{
     protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
     public $tablePrefix;
     public $tableName;

     public function before() {
       $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
       if ($this->tablePrefix <> '')
         $this->tableName = $this->tablePrefix.'status';
     }

   	public function safeUp()
   	{
   	  $this->before();
      $this->createTable($this->tableName, array(
               'id' => 'pk',
               'account_id'=>'integer default 0',
               'in_reply_to_status_id'=>'BIGINT(20) unsigned NOT NULL',
               'place_id'=>'integer default 0',
               'tweet_text' => 'TEXT NOT NULL',
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