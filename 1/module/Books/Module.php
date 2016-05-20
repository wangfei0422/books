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
        $module= include __DIR__ . '/config/module.config.php';
		$navigation= include __DIR__ . '/config/navigation.config.php';
		$tourists= include __DIR__ . '/config/tourists.config.php';
	    return array_merge($module,$navigation,$tourists);
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
		//字符编码待解决。。。
		header('Content-Type: text/html; charset=utf-8');
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
		$tourists			=	$event->getTarget()->getServiceManager()->get("Config")["tourists"];
					
		//如果用户未登录，并且请求url非网站入口，则重定向至网站入口进行登录。
		if(!$userManager->isLogged()){
			if($routeName!="sign_in" && !in_array($routeName,$tourists)){
				($userManager->getContainer())["jump_url"]= urlencode($_SERVER['REQUEST_URI']);
				$indexController->redirect()->toRoute("sign_in",array("last_url"=>$last_url));
			}
		}
		
		//管理员权限判断
		$user=$userManager->getCurrUser();
		$controller=$event->getRouteMatch()->getParam("controller");
		$action=$event->getRouteMatch()->getParam("action");
		if($user!=null && !$user->isManager()){
			if($controller=="Books\Controller\User" && substr($action,-6)=="Manage"){
				$indexController->redirect()->toRoute("not_manager");
			}
		}
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
