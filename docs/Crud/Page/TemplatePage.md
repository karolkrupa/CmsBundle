# TemplatePage - własny niestandardowy widok

TemplatePage pozawla na stworzenie własnego niestandardowego widoku. W skrócie - renderowanie własnego twiga w kontenerze dashboardu

#### Przykładowy kontroller
```php  
use Devster\CmsBundle\Controller\AbstractCrudController;
use Devster\CmsBundle\Crud\Common\TemplatePage\TemplatePagePayload;
  
class IndexController extends AbstractCrudController  
{
    #[Route('', name: 'dashboard')]  
    public function index(): Response  
    {  
        $pageBuilder = $this->getPageFactory()->createTemplatePageBuilder();  
  
        $pageBuilder->getView()  
            ->setTemplate('backend/dashboard.html.twig')  
            ->setTitle('Dashboard');  
  
        return $pageBuilder->getPage()->response(new TemplatePagePayload([
            // Dane przekazywane do twiga
            'registrationCnt' => $this->getRegistrationsCnt()
        ]));  
    }
}
```

#### Widok
```twig
{# backend/dashboard.html.tiwg #}

{% block content %}  
    <div class="space-y-4">  
        <h1>Dashboard</h1>

        <h2>Zarejestowanych: {{ registrationCnt }}</h2>
    </div>
{% endblock %}
```