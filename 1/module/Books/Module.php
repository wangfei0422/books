<?php
namespace Books;

use Zend\Mvc\MvcEvent;
use Books\Model\UserManager;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\SaveHandler\DbTableGateway;
use Zend\Session\SaveHandler\DbTableGatewayOptions;
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	public function onBootstrap($event){
		//全局变量
		global $g;
		$g=array();
		$g["App"]=$event->getTarget();
		
		//注册Mvc事件（判断是否已经登录）
		$events=$event->getTarget()->getEventManager();
		$events->attach(MvcEvent::EVENT_DISPATCH,array($this,"preDispatch"),101);
	}
	public function preDispatch($event){
		$routeName			=	$event->getRouteMatch()->getMatchedRouteName();
		$userManager		=	$event->getTarget()->getServiceManager()->get("Books\Model\UserManager");

		$indexController	=	$event->getTarget()->getServiceManager()->get("ControllerLoader")->get("Books\Controller\Index");
		$indexController->setEvent($event);
		//如果用户未登录，并且请求url非网站入口，则重定向至网站入口进行登录。
		if(!$userManager->isLogged() && $routeName!=="home"){
			$indexController->redirect()->toRoute("home");
		}
		
		//管理员权限判断
		$user=$userManager->getCurrUser();
		$controller=$event->getRouteMatch()->getParam("controller");
		$action=$event->getRouteMatch()->getParam("action");
		if($user!=null && !$user->isManager()){
			if($controller=="Books\Controller\User" && substr($action,-7)=="_manage"){
				$indexController->redirect()->toRoute("not_manager");
			}
		}
/* 		var_dump($user->getBooks()->toArray());
		var_dump($user->getArticles()->toArray());
		$user->log("Hello World!");
		var_dump($user->getLogs()->toArray());
		$last=new \DateTime("2016-5-11 12:00:00");
		$now =new \DateTime();
		var_dump($now->diff($last)->format("%R"));
		exit();*/
	}
	
	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'Zend\Session\SessionManager' => function ($sm) {
					$adapter=$sm->get('Zend\Db\Adapter\Adapter');
					$tableGateway = new TableGateway('Session', $adapter);
					$saveHandler = new DbTableGateway($tableGateway, new DbTableGatewayOptions());
					$config = new StandardConfig();
					$config->setOptions(array(
						'remember_me_seconds' =>3600,
						'name' => 'books',
					));
					$manager = new SessionManager($config);
					$manager->setSaveHandler($saveHandler);
					\Zend\Session\Container::setDefaultManager($manager);
					return $manager;
				},
			),
		);
	}
}
