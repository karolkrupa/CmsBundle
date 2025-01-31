import {contentSources} from "cmsbundle/tailwind";

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./src/**/*.php",

        ...contentSources()
    ],
    plugins: [
        require('cmsbundle/tailwind.pugin')
    ],
}

