<?php

namespace Devster\CmsBundle\Crud\List\FilterForm;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterFormHandler
{
    public function __construct(
        private readonly RequestStack         $requestStack,
        private readonly FormFactoryInterface $formFactory
    )
    {
    }

    public function handle(FilterForm $filterForm, QueryBuilder $qb, ?string $rootAlias = null): void
    {
        $form = $filterForm->getForm($this->formFactory);

        $serachFields = $filterForm->getSearchFields();
        $searchAdded = false;
        if (!empty($serachFields) && !$form->has('search')) {
            $form->add('search', TextType::class, [
                'label' => 'Wyszukaj',
                'required' => false
            ]);
            $searchAdded = true;
        }

        $filterData = $this->getFilterFormData($form, $this->requestStack->getCurrentRequest());

        $rootAlias = $rootAlias ?? $qb->getRootAliases()[0];

        if ($searchAdded && isset($filterData['search'])) {
            $where = '';

            foreach ($serachFields as $fieldName) {
                $aliasedFileName = $this->getQbFieldName($rootAlias, $fieldName);

                if ($where) {
                    $where .= ' OR ';
                }

                $where .= $aliasedFileName . ' LIKE :search';
            }

            $qb->andWhere($where)
                ->setParameter('search', '%' . $filterData['search'] . '%');
        }

        foreach ($filterData as $fieldName => $fieldValue) {
            if ($fieldName == 'search') continue;

            if ($fieldValue === null) {
                continue;
            }

            $fieldConfig = $this->getFieldConfig($filterForm, $fieldName, $rootAlias);
            $qbValueName = sprintf("%s_value", $fieldName);

            if ($handler = $fieldConfig->getHandler()) {
                $handler($fieldValue, $qb);
            } elseif ($mapping = $fieldConfig->getMapping()) {
                if (str_contains($mapping, ':value')) {
                    $mapping = str_replace(':value', ':' . $qbValueName, $mapping);
                    $qb->setParameter($qbValueName, $fieldValue, $fieldConfig->getParameterType());
                }

                $qb->andWhere($mapping);
            } else {
                $qb->andWhere(sprintf(
                    "%s = :%s",
                    $fieldConfig->getProperty(),
                    $qbValueName
                ))
                    ->setParameter($qbValueName, $fieldValue, $fieldConfig->getParameterType());
            }
        }
    }

    private function getFieldConfig(FilterForm $form, string $field, string $rootAlias): FormField
    {
        if (isset($form->getConfigurations()[$field])) {
            $config = $form->getConfigurations()[$field];
        } else {
            $config = new FormField();
        }

        if (!$config->getProperty()) {
            $config->setProperty($this->getQbFieldName($rootAlias, $field));
        }

        return $config;
    }

    protected function getFilterFormData(FormInterface $form, Request $request): array
    {
        if ($request->query->has($form->getName())) {
            $form->submit($request->query->all($form->getName()), true);
        }

        return $form->getData() ?? [];
    }

    private function getQbFieldName(?string $rootAlias, string $field): string
    {
        if (!$rootAlias) {
            return $field;
        }

        if (!str_contains($field, '.')) {
            return $rootAlias . '.' . $field;
        }

        return $field;
    }
}