<?php
/**
 * AdminBuilderSubscriber.php
 *
 * @since 15/10/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace esperanto\SliderBundle\EventListener;

use esperanto\AdminBundle\Event\RouteBuilderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use esperanto\AdminBundle\Builder\Route\SyliusRouteBuilder;
use esperanto\AdminBundle\Builder\View\ViewBuilder;
use esperanto\AdminBundle\Event\BuilderEvent;

class AdminBuilderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'esperanto_slider.slider.build_table_route' => array('onBuildTableRoute', 0),
            'esperanto_slider.slider.build_index_route' => array('onBuildIndexRoute', 0),
            'esperanto_slider.slider.post_build' => array('onPostBuild', 0),
        );
    }

    public function onBuildTableRoute(RouteBuilderEvent $event)
    {
        $event->getBuilder()->setTemplate('esperantoSliderBundle:Slider:table.html.twig');
    }

    public function onBuildIndexRoute(RouteBuilderEvent $event)
    {

    }

    public function onPostBuild(BuilderEvent $event)
    {
        $routeBuilder = new SyliusRouteBuilder();

        $view = new ViewBuilder();
        $view->setParameter('slide_sort_route', 'esperanto_slider_slider_sort');

        $routeBuilder
            ->setRouteName('esperanto_slider_slider_sort')
            ->setPattern('/slider/slider/sort')
            ->allowGetMethod()
            ->allowPostMethod()
            ->allowExpose()
            ->setController('esperanto_slider.controller.slider')
            ->setAction('batchAction')
            ->setAdmin('esperanto_slider.admin.slider')
            ->setViewBuilder($view)
            ->setTemplate('esperantoSliderBundle:Slider:sort.html.twig');

        $event->getBuilder()->addRouteBuilder($routeBuilder);
    }
}