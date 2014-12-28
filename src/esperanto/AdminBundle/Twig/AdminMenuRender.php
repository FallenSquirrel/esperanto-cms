<?php

namespace esperanto\AdminBundle\Twig;

use esperanto\AdminBundle\Admin\AdminRegister;
use esperanto\AdminBundle\Admin\Menu;
use esperanto\AdminBundle\Admin\MenuInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use esperanto\AdminBundle\Admin\Admin;

class AdminMenuRender extends \Twig_Extension
{
    /**
     * @var AdminRegister
     */
    protected $adminRegister;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var EngineInterface
     */
    protected $templateEngine;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $menus = array();

    /**
     * @param Container $container
     * @param $template string
     */
    public function __construct(Container $container, $template)
    {
        $this->container = $container;
        $this->template = $template;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('admin_menu_render', array($this, 'render'), array('is_safe' => array('html'))),
        );
    }

    public function render()
    {
        if($this->router === null) {
            $this->router = $this->container->get('router');
        }

        if($this->adminRegister === null) {
            $this->adminRegister = $this->container->get('esperanto_admin.admin_register');
        }

        if($this->templateEngine === null) {
            $this->templateEngine = $this->container->get('templating');
        }

        /** @var $request Request */
        $request = $this->container->get('request');

        $this->menus = array();
        /** @var $admin Admin */
        foreach($this->adminRegister->getAdmins() as $admin) {
            if($admin->isActionGranted(Admin::GRANTED_ACTION_INDEX)) {
                $menu = $admin->getMenu();
                if($menu instanceof MenuInterface) {
                    $this->menus[] = $menu;
                }
            }
        }
        $this->addLogout();

        return $this->templateEngine->render($this->template, array(
            'router' => $this->router,
            'menus' => $this->menus,
            'currentRoute' => $request->get('_route')
        ));
    }

    public function addLogout()
    {
        $menu = new Menu();
        $menu->setName('label.logout');
        $menu->setRouteName('fos_user_security_logout');
        $menu->setIconName('logout');
        $this->menus[] = $menu;
    }

    public function getName()
    {
        return 'admin_menu_render';
    }
} 