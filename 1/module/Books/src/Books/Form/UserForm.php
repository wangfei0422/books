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

class UserForm extends Form{            
    /**
    * @param    string $name    
    * @return   void
    */
    public function __construct($name=null){
     	parent::__construct("user");
		//id_user,name,type,head_image,qq_number,mail,status,pw
		$this->add(array(
			'name'=>'id_user',
			'type'=>'Hidden',
		));
		$this->add(array(
			'name'=>'name',
			'type'=>'Text',
			'options'=>array(
				'label'=>'UserName',
			),
		));
		$this->add(array(
			'name'=>'pw',
			'type'=>'Password',
			'options'=>array(
				'label'=>'密码',
			),
		));
		$this->add(array(
			'name'=>'head_image',
			'type'=>'Text',
			'options'=>array(
				'label'=>'头像',
			),
		));
		$this->add(array(
			'name'=>'qq_number',
			'type'=>'Text',
			'options'=>array(
				'label'=>'QQ号',
			),
		));
		$this->add(array(
			'name'=>'mail',
			'type'=>'Text',
			'options'=>array(
				'label'=>'邮件',
			),
		));
		$this->add(array(
			'name'=>'submit',
			'type'=>'Submit',
			'attributes'=>array(
				'value'=>'注册',
				'id'   =>'submitbutton',
			),
		));
    }  
}


?>