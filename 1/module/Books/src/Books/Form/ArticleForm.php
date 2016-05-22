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
use     Zend\Form\FormInterface;
class ArticleForm extends Form{            
    
    /**
    * @param    string $name    
    * @return   void
    */
    public function __construct($name=null){
     	parent::__construct("article");
		//id_article,title,date,content,status,id_user
		$this->add(array(
			'name'=>'id_article',
			'type'=>'Hidden',
		));
		$this->add(array(
			'name'=>'id_user',
			'type'=>'Hidden',
		));
		$this->add(array(
			'name'=>'title',
			'type'=>'Text',
			'options'=>array(
				'label'=>'标题',
			),
		));
		$this->add(array(
			'name'=>'content',
			'type'=>'Text',
			'options'=>array(
				'label'=>'内容',
			),
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