# DateCell - komórka daty


`DateCell` reprezentuje standardową komórkę daty. Komórka tego typu jest rozszerzeniem `TextCell`

## Przykładowe użycie

```php
use Devster\CmsBundle\Crud\List\Cell\DateCell;
use Devster\CmsBundle\Crud\Common\Alignment;
use Devster\CmsBundle\Crud\Common\VerticalAlignment;

$listPageBuilder->addField(  
    Field::create('name', DateCell::class)  
    ->setHeading('Nazwa')  
    ->setSortable()  
    ->configureCell(function(DateCell $cell) {  
        $cell  
            ->setFormat('Y-m-d H:i')
    })
)
```

## Metody
