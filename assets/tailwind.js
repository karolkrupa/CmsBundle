const path = require('path')

export function contentSources(vendorDir = 'vendor') {
    vendorDir = path.resolve(vendorDir, '.');
    const bundleDir = vendorDir + '/karolkrupa/cms-bundle';
    const assetsDir = path.resolve(bundleDir, './assets');

    return  [
        path.resolve(__dirname, './src/js') + '/**/*.{js,vue}',
        path.resolve(__dirname, './src/vue') + '/**/*.{js,vue}',
        bundleDir + "/templates/**/*.html.twig",
        bundleDir + "/src/**/*.php",
        "node_modules/preline/dist/*.js"
    ]
}