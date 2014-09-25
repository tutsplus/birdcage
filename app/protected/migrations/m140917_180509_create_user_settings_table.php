<?php

class m140917_180509_create_user_settings_table extends CDbMigration
{
   protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
   public $tablePrefix;
   public $tableName;

   public function before() {
     $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
     if ($this->tablePrefix <> '')
       $this->tableName = $this->tablePrefix.'user_setting';
   }

 	public function safeUp()
 	{
 	  $this->before();
  $this->createTable($this->tableName, array(
             'id' => 'pk',
             'user_id' => 'integer default 0',
             'twitter_key'=>'string default null',
             'twitter_secret'=>'string default null',
             'twitter_url'=>'string default null',
             'twitter_stream'=>'tinyint default 0',
             'created_at' => 'DATETIME NOT NULL DEFAULT 0',
             'modified_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
               ), $this->MySqlOptions);
               $this->createIndex('user_setting_user', $this->tableName , 'user_id', true);
               $this->addForeignKey('fk_user_setting_user', $this->tableName, 'user_id', $this->tablePrefix.'users', 'id', 'CASCADE', 'CASCADE');
 	}

 	public function safeDown()
 	{
 	  	$this->before();
 	  	$this->dropForeignKey('fk_user_setting_user', $this->tableName);
      $this->dropIndex('user_setting_user', $this->tableName);
 	    $this->dropTable($this->tableName);
 	}
}