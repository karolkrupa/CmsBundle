# Instalacja

### Konfiguracja backendu

1. Dodać repozytorium do composer.json

```json
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/karolkrupa/CmsBundle.git"
        }
]
```

2. Zainstalwoać pakiet (trzeba zainstalować knp paginator dodatkowo)
```bash
composer install karolkrupa/cmsbundle
```

3. Skonfigurować encje użytkownika + cale seciurity - https://symfony.com/doc/current/security.html
4. Użyć kontrollera logowania - `Devster\CmsBundle\Controller\AuthController`

## Konfiguracja frontendu

Przykładowa konfiguracja z separacją backendu (panel administratora) i frontendu (strona) w katalogach:

`/assets/backand` - Panel administratora  
`/assets/frontend` - Strona

### 1. Zainstalować webpack encore w projekcie
```bash
composer require symfony/webpack-encore-bundle
npm install
```

### 2. Utworzyć katalogi odpowiednie dla źródeł backendu i frontendu
```bash
mkdir -p assets/backend/src/js && mkdir assets/backend/src/css
mkdir -p public/backend/build
mkdir assets/frontend
```

### 3. Skonfigurować projekt node
```bash
cd assets/backend
npm init
```

### 4. Zainstalować i skonfigurować tailwinda
https://tailwindcss.com/docs/installation
```bash
npm install -D tailwindcss @tailwindcss/forms autoprefixer
npx tailwindcss init
```

```javascript
//
// postcss.config.js
//

module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
}
```

```javascript
//
// tailwind.config.js
//

import { contentSources } from 'cmsbundle/tailwind'

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        // Twoje pliki źródłowe 
        "./src/js/**/*.js",
        "./src/js/**/*.vue",
        
        // Pliki źródłowe symfony
        "../../templates/backend/**/*.html.twig",
        "../../templates/bundles/**/*.twig",
        "../../src/**/*.php",

        // Pliki źródłowe cmsbundle
        ...contentSources('../../vendor/'),
    ],
    // theme: {
    //     extend: {},
    // },
    plugins: [
        require('cmsbundle/tailwind.pugin'),
        require('@tailwindcss/forms'),
        require('preline/plugin')
    ],
}
```

```css
/* src/css/app.scss */

@tailwind base;
@tailwind components;
@tailwind utilities;
```

### 5. Skonfigurować pakiet CmsBundle
```bash
npm install github:karolkrupa/cms-bundle-js
```

```javascript
//
// src/cmsbundle.js
//

import CmsBundle from 'cmsbundle/bundle'
import './css/app.scss';

//
// Rejestracja własnego komponentu
//
// import NotificationMembersCount from "./src/js/components/NotificationMembersCount.vue";
// CmsBundle.registerVueComponent('notification-members-count', NotificationMembersCount)

CmsBundle.init()
```



### 6. Skonfigurować webpack encore

```bash
npm install @symfony/webpack-encore sass-loader@^16.0.1 sass vue-loader@^17.0.0 --save-dev
```

Konfiguracja skryptów w `package.json`
```json
"scripts": {
  "dev-server": "encore dev-server",
  "dev": "encore dev",
  "watch": "encore dev --watch",
  "build": "encore production --progress"
}
```

```javascript
//
// assets/backend/webpack.config.js
//

const Encore = require('@symfony/webpack-encore');

const {styles} = require('@ckeditor/ckeditor5-dev-utils');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // Kofniguracja katalogów dowolna, przedstawiona przykładowa 
    .setOutputPath('../../public/backend/build/')
    .setPublicPath('/backend/build')
    .setManifestKeyPrefix('backend/build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './src/cmsbundle.js')

    //
    // default encore config...
    //
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    
    //
    // Konfiguracja dla bundle
    //
    .enableSassLoader()
    .enableVueLoader()
    .enablePostCssLoader()
    
    .addRule({
        test: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/, loader: 'raw-loader'
    })

    // Configure other image loaders to exclude CKEditor 5 SVG files.
    .configureLoaderRule('images', loader => {
        loader.exclude = /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/;
    })

    // Configure PostCSS loader.
    .addLoader({
        test: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/, loader: 'postcss-loader', options: {
            postcssOptions: styles.getPostCssConfig({
                themeImporter: {
                    themePath: require.resolve('@ckeditor/ckeditor5-theme-lark')
                }
            })
        }
    })

    .configureDefinePlugin(options => {
        options.__VUE_OPTIONS_API__ = true;
        options.__VUE_PROD_DEVTOOLS__ = false;
        options.__VUE_PROD_HYDRATION_MISMATCH_DETAILS__ = false;
    })
;

module.exports = Encore.getWebpackConfig()
```

```yaml
#
# /config/packages/webpack_encore.yaml
#

webpack_encore:
  output_path: '%kernel.project_dir%/public/build'

  builds:
    backend: '%kernel.project_dir%/public/backend/build'
    # frontend: '%kernel.project_dir%/public/frontend/build'

framework:
  assets:
    packages:
      backend:
        json_manifest_path: '%kernel.project_dir%/public/backend/build/manifest.json'
      # frontend:
      #   json_manifest_path: '%kernel.project_dir%/public/frontend/build/manifest.json'
```


### 7. Konfiguracja assetów bundle

```yaml
#
# /config/packages/devster_cms.yaml
#

devster_cms:
  encore_entry: app
  encore_entrypoint: backend
```