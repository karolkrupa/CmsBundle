# EditPage - strona formularza

Typ strony przeznaczony do wyświetlania formularza, może służyć jako strona nowej encji lub edycji.

Przykładowa konfiguracja:

```php
$isNew = false;  
if (!$casting) {  
    $isNew = true;  
    $casting = new Casting();  
    $casting->addRequirement(new Requirements());  
}  

$pageFactory = new PageFactory();
$pageBuilder = $pageFactory->createEditPageBuilder();  
  
$pageBuilder->getView()  
    ->setTitle($isNew? 'Nowy casting' : 'Edycja castingu')  
    ->form($this->createForm(CastingType::class))  
    ->formTemplate('backend/casting/form.html.twig');  
  
$pageBuilder->setSuccessMessage(
    $isNew? 'Dodano nowy casting' : 'Zapisano zmiany'
);  
  
$reponse = $pageBuilder->getPage()->response(  
    new EditPagePayload($request, $casting)  
);
```