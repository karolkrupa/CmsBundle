# ConfirmationAction - Akcja wymagająca potwierdzenia 

`ConfirmationAction` odpowiada za standardową akcję uruchamiającą dany routing jednak dopiero w momencie potwierdzenia przez użytkownika. Potwierdzenie akcji odbywa się poprzez akceptację w modalu. Akcja ta rozszerza akcję `AnchorAction`

## Metody

##### `setModalTitle(string|\Clousure|null $title)`

Pozwala na ustawienie tytułu wyświetlanego modala.

##### `setModalText(string|\Clousure|null $text)`

Pozwala na ustawienie tytułu treści modala.

##### `setAcceptText(string|\Clousure|null $text)`

Pozwala na ustawienie treści przycisku akceptacji.

##### `setRejectText(string|\Clousure|null $text)`

Pozwala na ustawienie treści przycisku odrzucenia.

##### `setActivatorType(string $$type$)`

Pozwala na ustawienie typu aktywatora akcji, przycisku w komórce.

###### Dostępne opcje:
- `ConfirmationAction::TYPE_ANCHOR`
- `ConfirmationAction::TYPE_BUTTON
- `ConfirmationAction::TYPE_TEXT_BUTTON

## Przykład użycia

```php
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
```