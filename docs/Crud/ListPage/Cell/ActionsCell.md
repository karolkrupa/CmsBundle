# ActionsCell - pole wielu akcji


`ActionsCell` reprezentuje pole wielu akcji związane z encją. Może być to np. akcja podglądu, usuwania itp. Komórka akcji renderuje konkretną akcje z `Devster\CmsBundle\Crud\List\Action`

## Przykładowe użycie

```php
use Devster\CmsBundle\Crud\List\ActionsField;
use Devster\CmsBundle\Crud\List\Action\TextButtonAction;
use Devster\CmsBundle\Crud\List\Action\ConfirmationAction;
use Devster\CmsBundle\Crud\List\Action\Action;

$listPageBuilde->addField(  
    ActionsFiled::create('Akcje')  
        ->add(  
            TextButtonAction::create('Zobacz')  
                ->setRoute('backend.entity.show')  
                ->setRouteParams(['entity' => 'id'])  
                ->setColor(Action::COLOR_BLUE)  
        )  
        ->add(  
            ConfirmationAction::create('Usuń')  
                ->setRoute('backend.entity.remove')  
                ->setRouteParams(['entity' => 'id'])  
                ->setColor(Action::COLOR_RED)  
                ->setModalTitle('Czy na pewno chcesz usunąć?')  
                ->setModalText(function (Entity $entity) {  
                    return sprintf(  
                        'Czy na pewno chcesz usunąć <b>%s</b>?',  
                        $entity->getTitle()  
                    );  
                })  
        )  
)
```

## Metody
