<?php

namespace Devster\CmsBundle\Crud\List\FilterForm;

use Doctrine\ORM\QueryBuilder;

class FormField
{
    protected ?string $property = null;
    protected ?\Closure $handler = null;
    protected ?string $mapping = null;

    /**
     * Pole z query builder'a, po którym będzie filtrowanie. Np. "u.firstName"
     */
    public function property(string $property): static
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @param Closure(QueryBuilder $qb, mixed $value): void $handler
     */
    public function handler(\Closure $handler): static
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Mapping dla query builder'a. Np. "u.firstName = :value"
     *
     * Słowo kluczowe ":value" będzie podmieniane na wartość filtra
     */
    public function mapping(?string $mapping): static
    {
        $this->mapping = $mapping;

        return $this;
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function getHandler(): ?\Closure
    {
        return $this->handler;
    }

    public function getMapping(): ?string
    {
        return $this->mapping;
    }
}