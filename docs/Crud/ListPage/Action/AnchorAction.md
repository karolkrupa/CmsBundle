# AnchorAction - standardowy odnośnik

`AnchorAction` - Reprezentuje akcje jako zwykły odnośnik HTML. Akcja ta jest konfigurowana do uruchomienia odpowiedniego routingu po użyciu.

## Metody

##### `setRoute(string $route)`

Konfiguruje docelowy routing akcji

##### `setRouteParams(array|\Closure $routeParams)`

Konfiguruje parametry routingu. Może przyjmować tablicę lub callback, w przypadku callbacka uruchamiany jest z parametrem danych danego wiersza.

## Przykład użycia 

```php
AnchorAction::create('Zobacz')
    ->setRoute('backend.entity.show')
    ->setRouteParams([
        'entity' => 'id' // Wartości entity określona na podstawie gettera
    ])
    ->setRouteParams(function(Entity $entity) {
        return [
            'entity' => $entity->getId()
        ]
    });
```