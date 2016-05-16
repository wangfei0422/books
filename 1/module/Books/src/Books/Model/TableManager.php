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
    protected $tables=array();    
    
    protected $pks=array(
		"User"=>"id_user",
		"Book"=>"id_book",
		"BorrowedRecord"=>"id_borrowed_book",
		"BookFeedback"=>"id",
		"Article"=>"id_article",
		"Config"=>"name",
		"ArticleFeedback"=>"id",
		"Log"=>"id",
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
			if(class_exists($entityClass)){
				$entityInstance=new $entityClass();
				$entityInstance->setTable($tableInstance);
				$resultSetPrototype = new ResultSet();
				$resultSetPrototype->setArrayObjectPrototype($entityInstance);	
			}
			
			$tableInstance->setTableGateway(new TableGateway($table,$dbAdapter,null,$resultSetPrototype));
			$tableInstance->setPk(isset($this->pks[$table])?$this->pks[$table]:"id");
			$this->tables[$table]=$tableInstance;
		}
		return $this->tables[$table];

    }    
    
    
    

    

}


?>