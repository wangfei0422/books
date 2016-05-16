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
use		Zend\Db\TableGateway\TableGateway;
use		Zend\Db\ResultSet\ResultSet;
use		Zend\Db\Sql\Select;
use		Zend\Paginator\Adapter\DbSelect;
use		Zend\Paginator\Paginator;

class TableBase{
    
    /**
    * @var      string
    */
    private $pk;
    
    /**
    * @var      TableGateway
    */
    private $tableGateway;    
    
    //settor for $this->pk
    public function setPk($value){
       $this->pk=$value;
    }
    
    //gettor for $this->pk
    public function getPk(){
       return $this->pk;
    }
    
    //settor for $this->tableGateway
    public function setTableGateway($value){
       $this->tableGateway=$value;
    }
    
    //gettor for $this->tableGateway
    public function getTableGateway(){
       return $this->tableGateway;
    }    
    
    /**
    * @param    string $order    
    * @param    int $offset    
    * @param    int $limit    
    * @param    boolean $paginated    
    * @return   array
    */
    public function fetchAll($order="", $offset=0, $limit=1000, $paginated=false){
      	$tg=$this->tableGateway;
		$table=$tg->getTable();
		if($paginated){
			$select = new Select($table);
			
			$resultSetPrototype=null;
			$entityClass='Books\Model\\' . $table;
			if(class_exists($entityClass)){
				$resultSetPrototype = new ResultSet();
				$resultSetPrototype->setArrayObjectPrototype(new $entityClass());	
			}
			$paginatorAdapter = new DbSelect($select,$tg->getAdapter(),$resultSetPrototype);
			$paginator = new Paginator($paginatorAdapter);
			return $paginator;
		}
		return $tg->select(function($select) use($offset,$limit,$order){
			if(!empty($order))$select->order($order);
			$select->offset($offset);
			$select->limit($limit);
		});
    }
	
	
    /**
    * @param    mixed $id    
    * @return   EntityBase
    */
    public function get($id){
 		$tg=$this->tableGateway;
		$selectParam=array();
		$selectParam[$this->pk] = $id;
     	$rowSet=$tg->select($selectParam);
		$row=$rowSet->current();
		if(!$row)return null;
		return $row;
    }
    
    /**
    * @param    mixed $id    
    * @return   boolean
    */
    public function delete($id){
		$selectParam=array();
		$selectParam[$this->pk] = $id;
     	$this->tableGateway->delete($selectParam);
		return true;
    }
    
    /**
    * @param    array $data    
    * @return   boolean
    */
    public function save($data){
		$id = $data[$this->pk];
		if((is_integer($id) && $id==0) || is_string($id)) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->get($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception($this->tableGateway->getTable() . ' id does not exist');
			}
		}
		return true;
    }    
    
    
    

    

}


?>