<?php

namespace Devster\CmsBundle\Crud\List\FilterForm;

use Doctrine\ORM\QueryBuilder;

class FormField
{
    protected ?string $property = null;
    protected ?\Closure $handler = null;
    protected ?string $mapping = null;
    protected ?string $parameterType = null;

    /**
     * Pole do automatycznego bindowania wartości dla query buildera. Np. "u.firstName"
     */
    public function setProperty(string $property, ?string $parameterType = null): static
    {
        $this->property = $property;

        if ($parameterType) {
            $this->parameterType = $parameterType;
        }

        return $this;
    }

    /**
     * Handler do obsługi wartości z formularza
     *
     * @param Closure(mixed $value, QueryBuilder $qb): void $handler
     */
    public function setHandler(\Closure $handler): static
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Mapping dla query builder'a. Np. "u.firstName = :value"
     *
     * Słowo kluczowe ":value" będzie podmieniane na wartość filtra
     */
    public function setMapping(?string $mapping, ?string $parameterType = null): static
    {
        $this->mapping = $mapping;

        if ($parameterType) {
            $this->parameterType = $parameterType;
        }

        return $this;
    }

    /**
     * Typ parametru dla query buildera
     */
    public function setParameterType(?string $parameterType): static
    {
        $this->parameterType = $parameterType;

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

    public function getParameterType(): ?string
    {
        return $this->parameterType;
    }
}