# Integracja z CKEditor - edytor WYSIWYG

Typ formularza - `Devster\CmsBundle\Form\CKEditorType`

## Obsługa przesyłania plików

Domyślna konfiguracja CKEditor'a pozwala na dodawanie plików (obrazów). 

Pliki przesyłane są jako `FormData` poprzez request `POST` oraz wymagają obsługi na backendzie. Bundle po instalacji nie oferuje żadnej obsługi przesyłanych plików.

Aby obsłużyć pliki przesyłane przez CKEditor należy utworzyć endpoint obsługujący poniżej przedstawione żądanie:
```http
POST /file/upload/endpoint (FormData)
{
    "upload": <uploaded file>
}
```

W odpowiedzi powinny zostać zwrócone dane w następującym formacie:
```json
{
    "id": "media id", 
    "urls": {
        "default": "http://domain/media.jpg"
    }
}
```

### Implementacja obsługi przesyłania plików

Aby ułatwić implementacje obsługi przesyłania plików dla CKEditor bundle oferuje abstrakcyjny kontroler: `Devster\CmsBundle\Controller\AbstractCKEditorTypeController`. Kontroler ten posiada zdefiniowany route dla obsługi przesyłania plików z CKEditor, jedynym wymaganiem jest obsługi zapisu pliku poprzez implementację funkcji `upload(UploadedFile $file): array`, funkcja ta musi zwracać tablicę zawierającą identyfikator oraz adres url do pliku.

Przykładowa implementacja:
```php
#[Route('/api/ckeditor', name: 'api.ckeditor')]  
class CKEditorController extends AbstractCKEditorTypeController  
{  
    public function __construct(private readonly Uploader $uploader) {}  
  
    protected function upload(UploadedFile $file): array  
    {  
        $media = $this->uploader->upload($file);  
  
        return [  
            'id' => $media->getId(),  
            'url' => $this->getUrl()  
        ];  
    }  
}
```

Aby CKEditor mógł korzystać z tego kontrolera należy ustawić route w konfiguracja bundle:
```yml
# config/packages/devster_cms.yaml
devster_cms:
    ckeditor:
        file_upload_route: 'api.ckeditor'
```

Możliwe jest także ustawienie routingu dla każdego pola indywidualnie:
```php
$builder->add('text', CKEditorType::class, [  
    'label' => 'Text',  
    'constraints' => [  
        new NotBlank()  
    ],
    'route' => 'api.ckeditor'
]);
```

### Transformacja adresów przesłanych plików po zapisie formularza

Czasem wymagana jest zmiana adresu URL pliku w wynikowym HTML po wysłaniu formularza. Przykładowo: pliki przesyłane przez CKEditor są plikami tymczasowymi bądź zależy nam na umieszczeniu adresów do miniaturek w wynikowym tekście.

Po wysłaniu formularza z polem CKEditor, w przypadku kiedy zostały przesłane jakieś nowe pliki, odpalany jest event `Devster\CmsBundle\CKEditor\Event\MediaProcessingEvent` który to zawiera identyfikator pliku (zwrócony przy przesyłaniu pliku) oraz adres URL pliku (src). Zmiana adresu pliku umieszczonego w wynikowym HTML odbywa się poprzez użycie metody `MediaProcessingEvent::setSrc(string $newSource)` 

#### Przekazywanie własnych opcji

Możliwe jest przekazanie własnym opcji do handlera eventu `MediaProcessingEvent` takich jak np: nazwa docelowego systemu plików.

Aby przekazać opcje do handlera należy skorzystać z opcji `media_handler_options` dla typu formularza `CKEditorType`.

```php
# FormBuilder
$builder->add('text', CKEditorType::class, [  
    'label' => 'Text',  
    'constraints' => [  
        new NotBlank()  
    ],
    'media_handler_options' => [
        'filesystem' => 'content',
        'filesystem_prefix' => '/content',
        'thumbnail_size' => 'content'
    ]
]);

# Event subscriber
class MediaProcessingEventSubscriber implements EventSubscriberInterface {

    public function onMediaProcessingEvent(MediaProcessingEvent $event): void {
        $this->moveMediaToFilesystem(
            $event->getMediaId(),
            $event->getOptions()['filesystem'],
            $event->getOptions()['filesystem_prefix']
        );

        $thumbnailUrl = $this->getThumbnailUrl(
            $event->getMediaId(),
            $event->getOptions()['thumbnail_size']
        );

        $event->setSrc(thumbnailUrl);
    }
    
}
```
