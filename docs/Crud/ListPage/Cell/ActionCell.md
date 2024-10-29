# ActionCell - pole akcji


`ActionCell` reprezentuje pole akcji związane z encją. Może być to np. akcja podglądu, usuwania itp. Komórka akcji renderuje konkretną akcje z `Devster\CmsBundle\Crud\List\Action`

## Przykładowe użycie

```php
use Devster\CmsBundle\Crud\List\ActionField;
use Devster\CmsBundle\Crud\List\Action\TextButtonAction;
use Devster\CmsBundle\Crud\List\Action\Action;

$listPageBuilde->addField(  
    ActionFiled::create('Zobacz', TextButtonAction::class) 
        ->configureAction(function(TextButtonAction $action) {
            $action
                ->setRoute('backend.entity.show')  
                ->setRouteParams(['entity' => 'id'])  
                ->setColor(Action::COLOR_BLUE);
        })  
)
```

## Metody
