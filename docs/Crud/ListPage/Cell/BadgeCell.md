# BadgeCell - flaga


`BadgeCell` reprezentuje standardową komórkę flagi. Komórka tego typu jest rozszerzeniem `TextCell`

## Przykładowe użycie

```php
use Devster\CmsBundle\Crud\List\Cell\BadgeCell;
use Devster\CmsBundle\Crud\Common\Alignment;
use Devster\CmsBundle\Crud\Common\VerticalAlignment;

$listPageBuilder->addField(  
    Field::create('name', DateCell::class)  
    ->setHeading('Nazwa')  
    ->setSortable()  
    ->configureCell(function(BadgeCell $cell) {  
        $cell  
            ->setColor(BadgeCell::COLOR_BLUE)
    })
)
```

## Metody
