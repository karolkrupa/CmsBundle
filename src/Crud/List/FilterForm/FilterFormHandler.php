<?php

namespace Devster\CmsBundle\Crud\List\FilterForm;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterFormHandler
{
    public function __construct(
        private readonly RequestStack $requestStack
    )
    {
    }

    public function handle(FilterForm $filterForm, QueryBuilder $qb): void
    {
        $form = $filterForm->getForm();

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

        $rootAlias = $filterForm->getAlias() ?? $qb->getRootAliases()[0];

        if ($searchAdded && isset($filterData['search'])) {
            $where = '';

            foreach ($serachFields as $fieldName) {
                $aliasedFileName = $this->getSortFieldFromAlias($rootAlias, $fieldName);

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
                    $qb->setParameter($qbValueName, $fieldValue);
                }

                $qb->andWhere($mapping);
            } else {
                $qb->andWhere(sprintf(
                    "%s = :%s",
                    $fieldConfig->getProperty(),
                    $qbValueName
                ))
                    ->setParameter($qbValueName, $fieldValue);
            }
        }
    }

    private function getFieldConfig(FilterForm $form, string $field, string $rootAlias): FormField
    {
        if (isset($form->getConfigurations()[$field])) {
            return $form->getConfigurations()[$field];
        }

        $config = new FormField();
        $config->property($this->getSortFieldFromAlias($rootAlias, $field));

        return $config;
    }

    protected function getFilterFormData(FormInterface $form, Request $request): array
    {
        if ($request->query->has($form->getName())) {
            $form->submit($request->query->all($form->getName()), true);
        }

        return $form->getData() ?? [];
    }

    private function getSortFieldFromAlias(?string $rootAlias, string $sortField): string
    {
        if (!$rootAlias) {
            return $sortField;
        }

        if (!str_contains($sortField, '.')) {
            return $rootAlias . '.' . $sortField;
        }

        return $sortField;
    }
}