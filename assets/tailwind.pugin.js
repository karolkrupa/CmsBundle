const plugin = require('tailwindcss/plugin')

module.exports = plugin(function ({theme}) {}, {
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                inter: ['Inter', 'sans-serif']
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms')
    ]
})