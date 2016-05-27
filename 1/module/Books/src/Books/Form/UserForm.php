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
				'label'=>'用户名',
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
			),
		));
		$this->add(array(
			'name'=>'is_manager',
			'type'=>'checkbox',
			'options'=>array(
				'label'=>'设置为管理员',
				'checked_value'=>'1',
				'unchecked_value'=>'0',
				'label_attributes'=>array('class'=>'checkbox'),
			),
			'attributes'=>array(
				'value'=>'0'
			),
		));
		$this->add(array(
			'name'=>'user_type',
			'type'=>'radio',
			'options'=>array(
				'label'=>'请选择用户类型',
				'value_options'=>array(
					'0'=>'普通用户',
					'1'=>'大四学生'
				),
			),
			'attributes'=>array(
				'value'=>'0'
			),
		));
    } 
	
	public function getData($flag = FormInterface::VALUES_NORMALIZED){
		$data=parent::getData($flag);
		$u=new \Books\Model\User();
		if($data["is_manager"]==1)$u->setManager(true);
		else $u->setManager(false);
		$u->setType($data["user_type"]);
		$data['type']=$u['type'];
		unset($data['is_manager']);
		unset($data['user_type']);
		unset($data['submit']);
		return $data;
	}
}


?>