<?php
//
// +------------------------------------------------------------------------+
// | PHP Version 5                                                          |
// +------------------------------------------------------------------------+
// | ���ߣ�����                                                             |
// +------------------------------------------------------------------------+
// | ���ļ���powerdesigner���ɣ���ԭ�汾��������������������:               |
// | 1 �����������ռ�֧��                                                   |
// | 2 ������settor��gettor֧��                                             |
// +------------------------------------------------------------------------+
// | ʱ�䣺2016��5��                                                       |
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
			$this->tables[$table]=$tableInstance;								//����entityʵ����֮ǰ����ֹѭ�������ڴ������
			if(class_exists($entityClass)){
				$entityInstance=new $entityClass();								//entityʵ����
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