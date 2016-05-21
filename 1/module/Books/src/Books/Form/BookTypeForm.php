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
class BookTypeForm extends Form{            
    /**
    * @param    string $name    
    * @return   void
    */
    public function __construct($name=null){
     	parent::__construct("booktypes");
		$this->setAttribute('method', 'POST');
		$this->add(array(
			'name'=>'book_type',
			'type'=>'Text',
			'options'=>array(
				'label'=>'图书类型',
			),
		));
		$this->add(array(
			'name'=>'submit',
			'type'=>'Submit',
			'attributes'=>array(
				'value'=>'添加分类',
			),
		));
    } 
}


?>