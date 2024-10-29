# SortableButtonsAction - Akcja sortowania

`SortableButtonsAction` odpowiada za standardową akcję sortowania. Akcja ta w zależności od użytego kierunku sortowania uruchamia skonfigurowany routing z odpowiednim parametrem.
Akcja ta rozszerza `AnchorAction`

## Metody

##### `setSortDirectionParam(string $param)`

Pozwala na ustawienie nazwy parametru kierunku zmiany pozycji.

##### `setSortPreviousValue(string $prevValue)`

Pozwala na ustawienie wartości parametru w przypadku zmiany kolejności wstecz.

##### `setSortNextValue(string $prevValue)`

Pozwala na ustawienie wartości parametru w przypadku zmiany kolejności dalej.

## Przykład użycia

```php
ActionField::create('Kolejność', SortableButtonsAction::class)  
    ->configureAction(function (SortableButtonsAction $action) {  
        $action->setRoute('backend.entity.sort')  
            ->setRouteParams(['entity' => 'id']);  
    })  
    ->setFit()  
    ->configureCell(function (ActionCell $cell) {  
        $cell->setAlignment(Alignment::center);  
    })  
    ->setSortable()  
    ->setSortField('c.sort')
```

### Przykładowa akcja kontrolera

```php
use Devster\CmsBundle\Controller\SortableActionTrait;

class EntityController {
    use SortableActionTrait;

    #[Route('{entity}/_sort', name: 'backend.entity.sort', methods: ['GET'])] 
    public function sortAction(Entity $entity): RedirectResponse  
    {  
        return $this->commonSortAction(  
            $entity
        );  
    }
}
```