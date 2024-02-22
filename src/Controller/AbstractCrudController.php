<?php

namespace Devster\CmsBundle\Controller;

use Devster\CmsBundle\Crud\Action\Renderer\ActionRenderer;
use Devster\CmsBundle\Crud\List\Cell\ListFieldRendererInterface;
use Devster\CmsBundle\Crud\List\Cell\Renderer\ListFieldRenderer;
use Devster\CmsBundle\Crud\List\ListPageView;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class AbstractCrudController extends AbstractController implements ServiceSubscriberInterface
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            ...[
                PaginatorInterface::class,
//                'devster_cms.crud.list.field.renderer_locator' => 'devster_cms.crud.list.field.renderer_locator'
            ]
        ];
    }

    public function __construct(
        #[Autowire(service: 'devster_cms.crud.list.field.renderer_locator')]
        private readonly ServiceLocator $locatorRenderer
    )
    {
    }

    protected function renderList(
        ListPageView $view,
        QueryBuilder $data
    )
    {

        /** @var Paginator $pagination */
        $paginator = $this->container->get(PaginatorInterface::class);

        $pagination = $paginator->paginate($data->getQuery());

        /** @var ServiceLocator $renderers */
//        $renderers = $this->container->get('devster_cms.crud.list.field.renderer_locator');
        $data = [];
        foreach ($pagination as $entity) {
            $fields = [];

            foreach ($view->fields as $field) {
                /** @var ListFieldRendererInterface $renderer */
                $renderer = $this->locatorRenderer->get($field['renderer']);

                $fields[] = $renderer->render($field, $entity);
            }

            $data[] = $fields;
        }

        dump($data);


        return $this->render('@DevsterCms/crud/list/view.html.twig', [
            'view' => $view,
            'data' => $data,
            'pagination' => $pagination
        ]);
    }
}