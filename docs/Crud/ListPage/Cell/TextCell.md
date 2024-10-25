# TextCell - komórka tekstowa

`TextCell` reprezentuje standardową komórkę tekstową.

![[text.png]]

## Przykładowe użycie

```php
use Devster\CmsBundle\Crud\List\Cell\TextCell;
use Devster\CmsBundle\Crud\Common\Alignment;
use Devster\CmsBundle\Crud\Common\VerticalAlignment;

$listPageBuilder->addField(  
    Field::create('name', TextCell::class)  
    ->setHeading('Nazwa')  
    ->setSortable()  
    ->configureCell(function(TextCell $cell) {  
        $cell  
            ->setAlignment(Alignment::center)  
            ->setVerticalAlignment(VerticalAlignment::middle)  
            ->setTitle(function(Category $category) {  
                return $category->getName();  
            })  
            ->setBold(false)  
            ->setClass('text-blue-500')  
            ->setValue(function(Category $category) {  
                return $category->getName();  
            })  
            ->setTemplate('backend/cell/category_cell.html.twig');  
    })
)
```

## Metody

##### `setAlignment($alignment)`

Pozwala na ustawienie pozycji horyzontalnej.

##### `setVerticalAlignment($alignment)`

Pozwala na ustawienie pozycji werykalnej.

##### `setTitle($title)`

Pozwala na ustawienie tytułu komórki.

##### `setBold(bool $bold = true)`

Pozwala na ustawienie pogrubienia tekstu.

##### `setClass(string $class)`

Pozwala na ustawienie niestandardowej klasy komórki

##### `setValue(string|\Closure $class)`

Pozwala na ustawienie wartości komórki. W przypadku przekazania wartości typu `String` wartość komórki określona zostanie na podstawie getterów.
W przypadku callbacku w argumencie zostanie przekazana encja.

##### `setTemplate(string $template)`

Pozwala na ustawienie niestandardowego szablonu dla komórki