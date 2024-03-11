<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\TemplatePage\TemplatePageView;
use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\FilterForm\FilterForm;
use Devster\CmsBundle\Crud\List\Pagination\PaginationSettings;
use Devster\CmsBundle\Crud\List\Renderer\ListPageViewRenderer;

/**
 * Dto widoku listy
 */
class ListPageView extends TemplatePageView
{
    protected array $fields = [];
    protected array $actions = [];
    protected ?FilterForm $filterForm = null;
    protected ?PaginationSettings $pagination = null;
    protected ?string $template = '@DevsterCms/crud/list/view.html.twig';

    public function getRenderer(): string
    {
        return ListPageViewRenderer::class;
    }

    public function getHandler(): string
    {
        return ListPageViewHandler::class;
    }

    /**
     * Konfiguracja formularza filtrów
     *
     * @param FilterForm $form
     * @return $this
     */
    public function setFilterForm(FilterForm $form): static
    {
        $this->filterForm = $form;

        return $this;
    }

    /**
     * Dodanie kolumny tabeli
     *
     * @param $listField
     * @return $this
     */
    public function addField($listField): self
    {
        $this->fields[] = $listField;

        return $this;
    }

    /**
     * Dodanie akcji globalnej dla widoku listy
     *
     * @param ActionInterface $action
     * @return $this
     */
    public function addAction(ActionInterface $action): static
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Konfiguracja paginacji
     *
     * @param Closure(PaginationSettings $paginationSettings):void $closure
     * @return static
     */
    public function configurePagination(\Closure $closure): static
    {
        if (!$this->pagination) {
            $this->pagination = new PaginationSettings();
        }

        $closure($this->pagination);

        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getFilterForm(): ?FilterForm
    {
        return $this->filterForm;
    }

    /**
     * @return ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function getPagination(): ?PaginationSettings
    {
        return $this->pagination;
    }
}