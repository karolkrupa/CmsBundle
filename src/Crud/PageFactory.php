<?php

namespace Devster\CmsBundle\Crud;

use Devster\CmsBundle\Crud\Delete\DeletePageConfig;
use Devster\CmsBundle\Crud\Edit\EditPageConfig;
use Devster\CmsBundle\Crud\Edit\EditPageHandler;
use Devster\CmsBundle\Crud\List\ListPageConfig;
use Devster\CmsBundle\Crud\List\ListPageHandler;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;

class PageFactory
{
    public function __construct(
        #[TaggedLocator('devster.cms.page.handler')]
        private readonly ServiceLocator $handlers
    )
    {
    }

    public function createListPageBuilder(): ListPageConfig
    {
        return new ListPageConfig(
            $this->handlers->get(ListPageHandler::class)
        );
    }

    public function createEditPageBuilder(): EditPageConfig
    {
        return new EditPageConfig(
            $this->handlers->get(EditPageHandler::class)
        );
    }

    public function creteDeletePageBuilder(): DeletePageConfig
    {
        return new DeletePageConfig(
            $this->handlers->get(DeletePageConfig::class)
        );
    }
}