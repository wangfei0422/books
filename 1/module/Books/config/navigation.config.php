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
		'tourist'=>array(
			 array(
				'label'		=>'登录',
				'route'		=>'sign_in',
			 ),
			 array(
				'label'		=>'注册',
				'route'		=>'sign_up',
			 ),
			 array(
				'label'		=>'去百度',
				'uri'		=>'http://baidu.com',
			 ),
			 array(
				'label'		=>'友情链接',
				'uri'		=>'#',
				'pages'		=>array(
					 array(
						'label'		=>'PHP',
						'uri'		=>'http://php.org',
					 ),				
					 array(
						'label'		=>'百度',
						'uri'		=>'http://baidu.com',
					 ),
					 array(
						'label'		=>'新浪',
						'uri'		=>'http://sina.com',
					 ),
					 array(
						'label'		=>'12306',
						'uri'		=>'http://www.12306.cn',
					 ),
				),
			 ),
		),
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
				'label'		=>'管理',
				'uri'		=>'',
				'pages'		=>array(
					array(
						'label'		=>'添加图书',
						'route'		=>'book/default',
						'controller'=>'book',
						'action'	=>'add',	
					),
					array(
						'label'		=>'添加文章',
						'route'		=>'book/default',
						'controller'=>'article',
						'action'	=>'add',	
					),
					array(
						'mb'		=>true,
						'label'		=>'用户管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'userManage',	
					),
					array(
						'mb'		=>true,
						'label'		=>'图书管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'bookManage',	
					),
					array(
						'mb'		=>true,
						'label'		=>'图书评论管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'bookFeedbackManage',	
					),
					array(
						'mb'		=>true,
						'label'		=>'文章管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'articleManage',	
					),
					array(
						'mb'		=>true,
						'label'		=>'文章类型管理',
						'route'		=>'book/default',
						'controller'=>'user',
						'action'	=>'bookTypeManage',	
					),
					array(
						'mb'		=>true,
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
