<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Books;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Books\Controller\Index',
                        'action'     => 'start',
                    ),
                ),
            ),
            'not_manager' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/not_manager',
                    'defaults' => array(
                        'controller' => 'Books\Controller\User',
                        'action'     => 'notManager',
                    ),
                ),
            ),
            'sign_in' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/sign_in',
                    'defaults' => array(
                        'controller' => 'Books\Controller\Index',
                        'action'     => 'signIn',
                    ),
                ),
            ),
            'exit' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/exit',
                    'defaults' => array(
                        'controller' => 'Books\Controller\User',
                        'action'     => 'exit',
                    ),
                ),
            ),
            'main_page' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/index',
                    'defaults' => array(
                        'controller' => 'Books\Controller\Index',
                        'action'     => 'start',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'book' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/book',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Books\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
			
        ),
		'invokables'=>array(
			'Books\Model\UserManager'=>Model\UserManager::class,
			'Books\Model\TableManager'=>Model\TableManager::class,
			'Books\Model\ConfigManager'=>Model\ConfigManager::class,
			'Books\Model\HelperFunctions'=>Model\HelperFunctions::class,
		),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
/*             'Books\Controller\Index' => Controller\IndexController::class,
			'Books\Controller\User' => Controller\UserController::class,
            'Books\Controller\Book' => Controller\BookController::class,
			'Books\Controller\Article' => Controller\ArticleController::class,
            'Books\Controller\BookFeedback' => Controller\BookFeedbackController::class,
			'Books\Controller\ArticleFeedback' => Controller\ArticleFeedbackController::class,  */
        ),
        'abstract_factories' => array(
			'Books\Controller\Manager'=> new Controller\Manager(),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        //'base_path'=> '/public',
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
	'db' => array(
		'driver' =>'Mysqli',
		'database'=>'books',
		'username' =>'root',
		'password' =>'',
		'hostname' =>'127.0.0.1',
		'port'	   =>'3306',
		'charset'  =>'',
	 ),
);
