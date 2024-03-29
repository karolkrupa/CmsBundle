/** @type {import('tailwindcss').Config} */
module.exports = {
    // darkMode: 'class',
    content: [
        "./ExampleApp/src/**/*.php",


        "./assets/js/**/*.js",
        "./assets/js/**/*.vue",
        "./assets/app.js",
        "./templates/**/*.html.twig",
        "./src/**/*.php",
        "node_modules/preline/dist/*.js"
    ],
    // theme: {
    //     extend: {
    //         fontFamily: {
    //             inter: ['Inter', 'sans-serif']
    //         }
    //     },
    // },
    plugins: [
        require('./assets/tailwind.pugin')
        // require('@tailwindcss/forms'),
        // require('preline/plugin')
    ],
}

