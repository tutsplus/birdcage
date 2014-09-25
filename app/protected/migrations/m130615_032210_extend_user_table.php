<?php

class m130615_032210_extend_user_table extends CDbMigration
{
     protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
   public $tablePrefix;
   public $tableName;

   public function before() {
     $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
     if ($this->tablePrefix <> '')
       $this->tableName = $this->tablePrefix.'users';
   }

 	public function safeUp()
 	{
 	  $this->before();
    $this->addColumn($this->tableName,'eid','VARCHAR(128) DEFAULT NULL');
    $this->addColumn($this->tableName,'no_mail','tinyint default 0');
    $this->addColumn($this->tableName,'is_located','tinyint default 0');
    $this->createIndex('users_eid', $this->tableName , 'eid', true);    
 	}

 	public function safeDown()
 	{
 	  	$this->before();
 	  	$this->dropIndex('users_eid', $this->tableName);
      $this->dropColumn($this->tableName,'eid');
      $this->dropColumn($this->tableName,'no_mail');
      $this->dropColumn($this->tableName,'is_located');
 	}
}