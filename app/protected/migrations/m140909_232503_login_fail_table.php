<?php

class m140909_232503_login_fail_table extends CDbMigration
{
     protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
     public $tablePrefix;
     public $tableName;

     public function before() {
       $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
       if ($this->tablePrefix <> '')
         $this->tableName = $this->tablePrefix.'login_fail';
     }

    	public function safeUp()
    	{
    	  $this->before();
     $this->createTable($this->tableName, array(
                'id' => 'pk',
                'ip_address' => 'string NOT NULL',
                'username' => 'string NOT NULL',
                'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                  ), $this->MySqlOptions);
    	}

    	public function safeDown()
    	{
    	  	$this->before();
    	    $this->dropTable($this->tableName);
    	}
}