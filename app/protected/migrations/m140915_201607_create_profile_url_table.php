<?php

class m140915_201607_create_profile_url_table extends CDbMigration
{
   protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
   public $tablePrefix;
   public $tableName;

   public function before() {
     $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
     if ($this->tablePrefix <> '')
       $this->tableName = $this->tablePrefix.'profile_url';
   }

 	public function safeUp()
 	{
 	  $this->before();
    $this->createTable($this->tableName, array(
             'id' => 'pk',
             'twitter_user_id' => 'bigint(20) unsigned NOT NULL',
             'url' => 'string DEFAULT NULL',
             'created_at' => 'DATETIME NOT NULL DEFAULT 0',
             'modified_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
               ), $this->MySqlOptions);
      $this->createIndex('profile_user_id', $this->tableName , 'twitter_user_id', false);               
      $this->addForeignKey('fk_profile_url_user_id', $this->tableName, 'twitter_user_id', $this->tablePrefix.'twitter_user', 'twitter_user_id', 'CASCADE', 'CASCADE');               
 	}

 	public function safeDown()
 	{
 	  	$this->before();
 	  	$this->dropForeignKey('fk_profile_url_user_id', $this->tableName); 	  	
 	  	$this->dropIndex('profile_user_id', $this->tableName);        
 	    $this->dropTable($this->tableName);
 	}
}