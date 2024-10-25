# BoolCell - komórka logiczna

`BoolCell` reprezentuje standardową komórkę logiczną. Komórka tego typu jest rozszerzeniem `TextCell`

## Przykładowe użycie

```php
use Devster\CmsBundle\Crud\List\Cell\BoolCell;
use Devster\CmsBundle\Crud\Common\Alignment;
use Devster\CmsBundle\Crud\Common\VerticalAlignment;

$listPageBuilder->addField(  
    Field::create('name', BoolCell::class)  
    ->setHeading('Nazwa')  
    ->setSortable()  
    ->configureCell(function(TextCell $cell) {  
        $cell  
            ->setAsBadge(true)
            ->setAsIcon(false)
            ->setTrueValue('aktywny')
            ->setFalseValue('nieaktywny')
    })
)
```

## Metody

##### `setAsBadge(bool $asBadge)`
##### `setAsIcon(bool $asIcon)`
##### `setTrueValue(string|\Closure $trueValue)`
##### `setFalseValue(string|\Closure $falseValue)`
