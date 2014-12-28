<?php
/**
 * Admin.php
 *
 * @since 02/08/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace esperanto\AdminBundle\Admin;

use esperanto\AdminBundle\Builder\SyliusBuilder;
use esperanto\AdminBundle\Model\AdminView;
use esperanto\AdminBundle\Model\Route;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\RouteCollection;

class BaseAdmin implements Admin
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $bundle;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @param Container $container
     * @param $company
     * @param $bundle
     * @param $entity
     */
    public function __construct(Container $container, $company, $bundle, $entity)
    {
        $this->container = $container;
        $this->company = $company;
        $this->bundle = $bundle;
        $this->entity = $entity;
    }

    public function init()
    {
        $builder = new SyliusBuilder(
            $this->container->get('event_dispatcher'),
            $this->company,
            $this->bundle,
            $this->entity
        );
        $this->config = $builder->getConfig();
    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
        if($this->routeCollection === null) {
            $this->routeCollection = new RouteCollection();
            /** @var $route Route */
            foreach($this->config->getRoutes() as $route) {
                $this->routeCollection->add($route->getRouteName(), $route->getRoute());
            }
        }

        return $this->routeCollection;
    }

    /**
     * @return AdminView
     */
    public function createView()
    {
        $view = new AdminView($this->config);
        if($this->config->getRoute('create')) {
            $view->setCreateRoute($this->config->getRoute('create')->getRouteName());
        }

        if($this->config->getRoute('table')) {
            $view->setTableRoute($this->config->getRoute('table')->getRouteName());
        }

        if($this->config->getRoute('index')) {
            $view->setIndexRoute($this->config->getRoute('index')->getRouteName());
        }

        if($this->config->getRoute('edit')) {
            $view->setEditRoute($this->config->getRoute('edit')->getRouteName());
        }

        if($this->config->getRoute('delete')) {
            $view->setDeleteRoute($this->config->getRoute('delete')->getRouteName());
        }

        $view->setAddButtonText('button.add_'.$this->entity);
        $view->setEmptyTableText('text.empty_'.$this->entity);

        return $view;
    }

    public function getMenu()
    {
        return $this->config->getMenu('default');
    }

    public function isActionGranted($action)
    {
        $role = strtoupper(sprintf('ROLE_%s_%s_ADMIN_%s_%s',
            $this->company,
            $this->bundle,
            $this->entity,
            $action
        ));

        if ($this->container->get('security.context')->isGranted($role)) {
            return true;
        }

        return false;
    }
}