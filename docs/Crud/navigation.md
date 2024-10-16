# Nawigacja

Konfiguracja nawigacji/menu odbywa się w pliku: `config/navbar.yaml`

```yaml
# config/navbar.yaml

sidebar:  
  - name: 'Menu'
    label_hidden: false  
    elements:  
      - name: 'Dashboard'  
        icon: 'backend/icon/dashboard.svg.twig' # Ikona elementu w menu  
        route: backend.dashboard # Route elementu  
      - name: 'Użytkownicy'  
        icon: 'backend/icon/users.svg.twig'  
        roles: [ 'ROLE_ADMIN' ] # Role wymagane do wyświetlenia elementu  
        elements: # Elementy rozwijanego menu  
          - name: 'Wszyscy'  
            route: backend.dashboard  
          - name: 'Usunięci'  
            route: backend.dashboard
```

![[images/navbar.png]]