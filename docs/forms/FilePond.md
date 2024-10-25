# Integracja z FilePond - uploader plików

Pole `FilePondType` reprezentuje asynchroniczny uploader plików

![[single.png]]

## Schemat działania

FilePond - asynchroniczny uploader plików javascript. Pliki z pola typu FilePondType
przesyłane są asynchronicznie po wybraniu przez użytkownika za pomocą API.

API w odpowiedzi zwraca `ID` pliku które następnie jest przesyłane do serwera w
momencie wysyłki formularza.

W momencie wysyłki formularza identyfikatory plików konwertowane są na obiekty
typu `UploadedFileDto` i zwracane jako wartość pola formularza. 
Domyślnie `FilePondType` jako wartości przyjmuje obiekty typu `FileDto<UploadedFileDto>` zawierające informacje o pliku (nazwa, rozmiar, mime-type,  URL podglądu).

Możliwa jest zmiana domyślnie obsługiwanego typu danych poprzez wykorzystanie wbudowanego transformatora danych (`ModelTransformer`).
Aby to zrobić należy skonfigurować opcję `model_transformer_options`, po konfiguracji
skonfigurowana encja będzie automatycznie transformowana do wewnętrznego formatu
`FileDto`. Przesłane identyfikatory będą także transformowane na skonfigurowaną encję poprzez `ID` zwrócone z API po przesłaniu pliku. Zachowanie pola formularza będzie więc
zbliżone do zachowania `EntityType`.

## Przykład użycia

```php
$builder->add('media', FilePondType::class, [
    'label' => "Obraz",
    'attr' => [  
        'accept' => 'image/png, image/jpeg, image/gif'  
    ],
    'route' => 'backend.api.file_upload',
    'multiple' => false,
    'model_transformer_options' => [  
        'class' => Media::class,  
        'id_field' => 'id',  
        'size_field' => function (Media $media) {  
            return $media->getFile()->getSize();  
        },  
        'mime_field' => function (Media $media) {  
            return $media->getFile()->getMime();  
        },  
        'filename_field' => function (Media $media) {  
            return $media->getFile()->getOriginalName();  
        },  
        'preview_url' => null  
    ]  
]);
```

## Opcje

##### `route`

**typ:** `String` **domyślnie:** null (lub wartość z konfiguracji bundle)

Opcja ta pozwala na ustawienie `routingu` dla kontrolera uploadu plików.

##### `multiple`

**typ:** `Boolean` **domyślnie:** false

Opcja ta pozwala na przesyłanie wielu plików

##### `allow_delete`

**typ:** `Boolean` **domyślnie:** false

Opcja pozwala na włączenie możliwości usuwania plików. W przypadku wyłączenia, występuje walidacja po wysłaniu.

##### `new_file_callback`

**typ:** `Callable` **domyślnie:** null

Opcja pozwala na ustawienia callbacku dla nowych plików. Callback ten uruchamiany jest po wysłaniu formularza kiedy nie ma błędów walidacji. Może służyć do przenoszenia plików w docelowe miejsce po zapisaniu formularza.

##### `delete_file_callback`

**typ:** `Callable` **domyślnie:** null

Opcja pozwala na ustawienia callbacku dla usuwanych plików.  Callback ten uruchamiany jest po wysłaniu formularza kiedy nie ma błędów walidacji. Może służyć do obsługi usuwania istniejących plików z dysku.

##### `model_transformer_options`

**typ:** `Array` **domyślnie:**
```php
[  
    'class' => null,  
    'id_field' => 'id',  
    'size_field' => 'size',  
    'mime_field' => 'mimeType',  
    'filename_field' => 'filename',  
    'preview_url' => null  
]
```

Opcja pozwala na uruchomienie wbudowanego transformatora danych (`ModelTransformer`) dla encji `doctrine`.  Odpowiednia konfiguracja pozwala na używanie `FilePondType` bezpośrednio z encjami.
##### `model_transformer_options[class]`

**typ:** `String` **domyślnie:** null

Opcja pozwala na zdefiniowanie typu encji do jakiej będzie następowała transformacja. W przypadku ustawienia wartości na `null` transformacja jest nieaktywna.

##### `model_transformer_options[id_field]`

**typ:** `String|Callable` **domyślnie:** id

Opcja pozwala na zdefiniowanie pola odpowiadającemu `ID` encji. Pole może przyjmować wartości typu `String`, w takim przypadku transformacja następuje na podstawie getterów encji. W przypadku wartości typu `Callable` wywoływany jest przekazany callback z encją w pierwszym argumencie.

##### `model_transformer_options[size_field]`

**typ:** `String|Callable|null` **domyślnie:** size

Opcja pozwala na zdefiniowanie pola odpowiadającemu polu zawierającemu wielkość danego pliku. 

##### `model_transformer_options[mime_field]`

**typ:** `String|Callable|null` **domyślnie:** mimeType

Opcja pozwala na zdefiniowanie pola odpowiadającemu polu zawierającemu typ pliku (`mime type`). 

##### `model_transformer_options[filename_field]`

**typ:** `String|Callable|null` **domyślnie:** filename

Opcja pozwala na zdefiniowanie pola odpowiadającemu polu zawierającemu nazwę pliku.

##### `model_transformer_options[preview_url]`

**typ:** `Callable` **domyślnie:** null

Opcja pozwala na zdefiniowanie callbacku zwracającego adres URL do podglądu pliku. Podgląd działa jedynie w przypadku grafik. 
