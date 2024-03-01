<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Devster\CmsBundle\Crud\List\Heading\Heading;

abstract class AbstractField
{
    protected Heading $heading;
    protected bool $fit = false;
    protected bool $sortable = false;
    protected ?string $sortField = null;
    protected ?\Closure $dataTransformer = null;

    public function __construct(
        protected readonly string $property
    )
    {
        $this->heading = new Heading($this->property);
        $this->sortField = $this->property;
    }

    static public function create(string $property): static
    {
        return new static($property);
    }

    /**
     * Abstract methods
     * ----------------
     */

    abstract public function getCell(): CellInterface;

    /**
     * Setters
     * -------
     */

    /**
     * Konfiguracja komórki tabeli
     *
     * @param Closure(CellInterface $cell):void $closure
     * @return $this
     */
    public function configureCell(\Closure $closure): static
    {
        $closure($this->getCell());

        return $this;
    }

    /**
     * Konfiguracja nagłówka kolumny tabeli
     *
     * @param string|Heading $heading
     * @return $this
     */
    public function setHeading(string|Heading $heading): static
    {
        if (is_string($heading)) {
            $this->heading->setText($heading);
        } else {
            $this->heading = $heading;
        }

        return $this;
    }

    /**
     * Konfiguracja dopasowania szerokości kolumny tabeli
     *
     * @param bool $fit
     * @return $this
     */
    public function setFit(bool $fit = true): static
    {
        $this->fit = $fit;

        return $this;
    }

    /**
     * Konfiguracja możliwości sortowania kolumny tabeli
     *
     * @param bool $sort
     * @return $this
     */
    public function setSortable(bool $sort = true): static
    {
        $this->sortable = $sort;

        return $this;
    }

    /**
     * Konfiguracja pola, po którym odbywa się sortowanie kolumny
     *
     * @param string|null $sortField
     * @return $this
     */
    public function setSortField(?string $sortField): static
    {
        $this->sortField = $sortField;

        $this->setSortable(true);

        return $this;
    }

    /**
     * Transformer that allows transform row data before passing to cell
     *
     * @param \Closure|null $dataTransformer
     * @return $this
     */
    public function setDataTransformer(?\Closure $dataTransformer): AbstractField
    {
        $this->dataTransformer = $dataTransformer;

        return $this;
    }

    /**
     * Getters
     * -------
     */
    public function getHeading(): Heading
    {
        return $this->heading;
    }

    public function isFit(): bool
    {
        return $this->fit;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function getSortField(): ?string
    {
        return $this->sortField;
    }

    public function getDataTransformer(): ?\Closure
    {
        return $this->dataTransformer;
    }
}