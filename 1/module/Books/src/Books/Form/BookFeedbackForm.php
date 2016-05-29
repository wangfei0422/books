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
class BookFeedbackForm extends Form{            
    
   /**
    * @param    string $name    
    * @return   void
    */
    public function __construct($name=null){
     	parent::__construct("BookFeedback");
		//id_article,title,date,content,status,id_user
		$this->add(array(
			'name'=>'id',
			'type'=>'Hidden',
		));
		$this->add(array(
			'name'=>'id_user',
			'type'=>'Hidden',
		));
		$this->add(array(
			'name'=>'id_book_borrowed',
			'type'=>'Hidden',
		));
		$this->add(array(
			'name'=>'feedback',
			'type'=>'Text',
			'options'=>array(
				'label'=>'评论',
			),
		));
		$this->add(array(
			'name'=>'star',
			'type'=>'Select',
			'options'=>array(
				'label'=>'请给文章打分',
				'value_options'=>array(
					'0'=>"0分",
					'1'=>"1分",
					'2'=>"2分",
					'3'=>"3分",
					'4'=>"4分",
					'5'=>"5分",
				),
			),
		));
		$this->add(array(
			'name'=>'submit',
			'type'=>'Submit',
			'attributes'=>array(
				'value'=>'提交',
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