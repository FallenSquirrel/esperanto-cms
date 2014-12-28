<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.09.14
 * Time: 18:26
 */

namespace esperanto\PageBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactory;
use esperanto\PageBundle\Form\Type\PageType;

class PageResolver
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getPage(Request $request)
    {
        if($request->get('id') == 'preview' && $request->getMethod() === 'POST')
        {
            $page = $this->getPreviewPage($request);
        } else {
            $page = $this->getLivePage($request);
        }

        return $page;
    }

    public function getPreviewPage(Request $request)
    {
        /** @var $formFactory FormFactory */
        $formFactory = $this->container->get('form.factory');
        $form = $formFactory->create('esperanto_page_page');
        $form->submit($request);
        return $form->getData();
    }

    public function getLivePage(Request $request)
    {
        /** @var $doctrine EntityManager */
        $doctrine = $this->container->get('doctrine');
        $id = $request->get('id');

        $repository = $this->container->get('esperanto_page.repository.page');
        $page = $repository->find($id);
        return $page;
    }
} 