<?php

namespace Devster\CmsBundle\Form\RemoteChoiceType;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('devster.remote.select.provider')]
interface ChoiceProviderInterface
{
    static public function getKey(): string;

    /**
     * Zwaraca opcje dla podanych parametrów
     *
     * @param int $page
     * @return PaginatedChoiceListInterface choices
     */
    public function getChoices(int $page = 1, ?string $search = null): PaginatedChoiceListInterface;

    /**
     * Tworzy obiekty widoku dla danych opcji
     *
     *      $provider->createView($em->getRepository(Entity::class)->findAll())
     *
     * Wynikiem powinno być:
     *
     *      [
     *          ChoiceView{ label: "Encja 1", value: 1 },
     *          ChoiceView{ label: "Encja 2", value: 2 }
     *      ]
     *
     * @param mixed[] $choices
     * @return ChoiceView[]
     */
    public function createView(array $choices): array;

    /**
     * Zwraca opcje dla wartości tych opcji.
     * Wartości tych opcji muszą być stringiem, np. id encji
     *
     *      $provider->getChoicesForValues([1, 2])
     *
     * Wynikiem powinno być:
     *
     *      [
     *          Entity{ id: 1 },
     *          Entity{ id: 2 }
     *      ]
     *
     * @param string[] $values
     * @return mixed[]
     */
    public function getChoicesForValues(array $values): array;

    /**
     * Zwraca wartości dla opcji. Wartości muszą być stringiem, np. id encji
     *
     *       $provider->getChoicesForValues($em->getRepository(Entity::class)->findAll())
     *
     *  Wynikiem powinno być:
     *
     *       [ "1", "2" ]
     *
     * @param mixed[] $choices
     * @return string[]
     */
    public function getValuesForChoices(array $choices): array;
}