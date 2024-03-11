# ListPage - tabela

![[images/list_page.png]]

Konfiguracja tego typu strony polega na skonfigurowaniu "pól" odpowiadających atrybutom danych wyświetlanych w tabeli.

**Obsługiwane źródła danych:**
- QueryBuilder
- Array

Przykładowa konfiguracja ListPage:

```php
$formFactory = new FormFactory();

$pageBuilder = $formFactory->createListPageBuilder();

$pageBuilder->getView()
    ->setTitle('Castingi')  
    ->setFilterForm(  
        FilterForm::create()->setSearchFields(['c.title', 'c.city'])  
    )  
    ->addField(  
        Field::create('title')  
            ->setHeading('Tytuł')  
            ->setSortable()  
    )  
    ->addField(  
        Field::create('published', BoolCell::class)  
            ->setHeading('Opublikowany')  
            ->setSortable()  
    )  
    ->addField(  
        Field::create('date', DateCell::class)  
            ->setHeading('Data')  
            ->setSortable()  
    )  
    ->addField(  
        Field::create('city')  
            ->setHeading('Miasto')  
            ->setSortable()  
    )  
    ->addField(  
        Field::create('createdAt', DateCell::class)  
            ->setHeading('Utworzono')  
            ->setSortable()  
    )  
    ->addField(  
        ActionsFiled::create('actions')  
            ->add(  
                AnchorAction::create('Zobacz')  
                    ->setRoute('backend.casting.show')  
                    ->setRouteParams(['casting' => 'id'])  
                    ->setColor(Action::COLOR_BLUE)  
            )  
            ->add(  
                ConfirmationAction::create('Usuń')  
                    ->setRoute('backend.casting.remove')  
                    ->setRouteParams(['casting' => 'id'])  
                    ->setColor(Action::COLOR_RED)  
                    ->setModalTitle('Czy na pewno chcesz usunąć?')  
                    ->setModalText(function (Casting $casting) {  
                        return sprintf(  
                            'Czy na pewno chcesz usunąć casting <b>%s</b>?',  
                            $casting->getTitle()  
                        );  
                    })  
            )  
    )  
    ->addAction(  
        ButtonAction::create('Nowy casting')  
            ->setRoute('backend.casting.new')  
            ->setColor(Action::COLOR_GREEN)  
    );

$qb = /* query builder */;

$response = $pageBuilder->getPage()->response(new ListPagePayload($qb));
```
