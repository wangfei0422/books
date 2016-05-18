<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Books;
// mb==true 管理员行为。
return array(
	'navigation' => array(
		'default' => array(
			 array(
				'label'		=>'用户',
				'route'		=>'book/default',
				'controller'=>'user',
				'action'	=>'list',
			 ),
			 array(
				'label'		=>'图书',
				'route'		=>'book/default',
				'controller'=>'book',
				'action'	=>'list',	
			 ),
			 array(
				'label'		=>'文章',
				'route'		=>'book/default',
				'controller'=>'article',
				'action'	=>'list',	
			 ),
			 array(
				'label'		=>'退出',
				'route'		=>'book/default',
				'controller'=>'user',
				'action'	=>'exit',		 
			 ),

			 array(
				'mb'		=>true,
				'label'		=>'管理',
				'uri'		=>'',
				'pages'		=>array(
					array(
						'label'		=>'用户管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'userManage',	
					),
					array(
						'label'		=>'图书管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'bookManage',	
					),
					array(
						'label'		=>'借阅记录管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'borrowedRecordManage',	
					),
					array(
						'label'		=>'图书评论管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'bookFeedbackManage',	
					),
					array(
						'label'		=>'文章管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'articleManage',	
					),
					array(
						'label'		=>'文章类型管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'bookTypeManage',	
					),
					array(
						'label'		=>'文章评论管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'articleFeedbackManage',	
					),
				),
			 ),
		 ),
	 ),
);
