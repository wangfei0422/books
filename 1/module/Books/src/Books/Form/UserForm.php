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
				'label'=>'����',
			),
		));
		$this->add(array(
			'name'=>'head_image',
			'type'=>'Text',
			'options'=>array(
				'label'=>'ͷ��',
			),
		));
		$this->add(array(
			'name'=>'qq_number',
			'type'=>'Text',
			'options'=>array(
				'label'=>'QQ��',
			),
		));
		$this->add(array(
			'name'=>'mail',
			'type'=>'Text',
			'options'=>array(
				'label'=>'�ʼ�',
			),
		));
		$this->add(array(
			'name'=>'submit',
			'type'=>'Submit',
			'attributes'=>array(
				'value'=>'ע��',
				'id'   =>'submitbutton',
			),
		));
    }  
}


?>