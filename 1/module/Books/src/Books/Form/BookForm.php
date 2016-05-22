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

namespace Books\Form;

use		Zend\Form\Form;
use		Zend\Form\FormInterface;
class BookForm extends Form{            

    /**
    * @param    string $name    
    * @return   void
    */
    public function __construct($name=null){
     	parent::__construct("book");
		//id_book,type,sub_type,name,thumb_image,big_image,id_user,description,pledge,status
		$this->add(array(
			'name'=>'id_book',
			'type'=>'Hidden',
		));
		$this->add(array(
			'name'=>'id_user',
			'type'=>'Hidden',
		));
		global $g;
		$types=$g["App"]->getServiceManager()->get("Books\Model\ConfigManager")->getBookTypes();
		$typesName=[];
		foreach($types as $i=>$type){
			$typesName[$i]=$type["name"];
		}
		$this->add(array(
			'name'=>'type',
			'type'=>'Select',
			'options'=>array(
				'label'=>'请选择图书类型',
				'value_options'=>$typesName,
			),
		));
		$this->add(array(
			'name'=>'sub_type',
			'type'=>'Select',
			'options'=>array(
				'label'=>'请选择图书子类型',
				'value_options'=>array('0'=>'默认'),
			),
		));
		$this->add(array(
			'name'=>'name',
			'type'=>'Text',
			'options'=>array(
				'label'=>'书名',
			),
		));
		$this->add(array(
			'name'=>'thumb_image',
			'type'=>'Text',
			'options'=>array(
				'label'=>'小图',
			),
		));
		$this->add(array(
			'name'=>'big_image',
			'type'=>'Text',
			'options'=>array(
				'label'=>'大图',
			),
		));
		$this->add(array(
			'name'=>'description',
			'type'=>'Text',
			'options'=>array(
				'label'=>'描述',
			),
		));
		$this->add(array(
			'name'=>'pledge',
			'type'=>'Text',
			'options'=>array(
				'label'=>'押金',
			),
			'attributes'=>array('value'=>0,),
		));
		$this->add(array(
			'name'=>'submit',
			'type'=>'Submit',
			'attributes'=>array(
				'value'=>'添加',
			),
		));
 		$this->add(array(
			'name'=>'is_verified',
			'type'=>'checkbox',
			'options'=>array(
				'label'=>'审核通过？',
				'checked_value'=>'1',
				'unchecked_value'=>'0',
				'label_attributes'=>array('class'=>'checkbox'),
			),
			'attributes'=>array(
				'value'=>'0'
			),
		));
	}
	
	
 	public function getData($flag = FormInterface::VALUES_NORMALIZED){
		$data=parent::getData($flag);
		unset($data['submit']);
		unset($data['is_verified']);
		return $data;
	} 
}


?>