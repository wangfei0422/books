<?php
//
// +------------------------------------------------------------------------+
// | PHP Version 5                                                          |
// +------------------------------------------------------------------------+
// | 作者：王梦                                                             |
// +------------------------------------------------------------------------+
// | 类文件由powerdesigner生成，在原版本基础上增加了以下属性:               |
// | 1 增加了命名空间支持                                                   |
// | 2 增加了settor和gettor支持                                             |
// +------------------------------------------------------------------------+
// | 时间：2016年5月                                                       |
// +------------------------------------------------------------------------+
//


/**
* @author       WANGMENG
*/

namespace Books\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
class TableManager{
    
    /**
    * @var      array
    */
    private $tables;
	
    protected $pks=array(
		"Config"=>"name",
		"ArticleFeedback"=>"id",
		"Article"=>"id_article",
		"BookFeedback"=>"id",
		"BorrowedRecord"=>"id_borrowed_book",
		"Book"=>"id_book",
		"Log"=>"id",
		"User"=>"id_user",
	);    
    
    /**
    * @param    string $table    
    * @return   TableBase
    */
    public function getTable($table){
		global $g;
		$sm=$g['App']->getServiceManager();
		$tables=$this->tables;
 		if(!isset($tables[$table])){
			$tableClass='\Books\Model\\' . $table . 'Table';
			$tableInstance=new $tableClass();
			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
			
			$resultSetPrototype=null;
			$entityClass='Books\Model\\' . $table;
			$this->tables[$table]=$tableInstance;								//放在entity实例化之前，阻止循环调用内存溢出。
			if(class_exists($entityClass)){
				$entityInstance=new $entityClass();								//entity实例化
				$entityInstance->setTable($tableInstance);
				$resultSetPrototype = new ResultSet();
				$resultSetPrototype->setArrayObjectPrototype($entityInstance);	
			}
			
			$tableInstance->setTableGateway(new TableGateway($table,$dbAdapter,null,$resultSetPrototype));
			$tableInstance->setPk(isset($this->pks[$table])?$this->pks[$table]:"id");
		}
		return $this->tables[$table];

    }    
    
    /**
    * @param    array $tables    
    * @param    EntityBase $entity    
    * @return   boolean
    */
    public function deleteWith($tables, EntityBase $entity){
		if(empty($table)) return;
		$allTables=array_keys($this->pks);
		foreach($tables as $table){
			if(in_array($table,$allTables)){
				$t=$this->getTable($table);
				$entities=$t->fetchAllForEntity($entity);
				foreach($entities as $e)$e->delete();
			}
		}
    }    

}


?>