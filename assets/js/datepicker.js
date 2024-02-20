// import 'vanillajs-datepicker/css/datepicker.css'
//
// import Datepicker from 'vanillajs-datepicker/Datepicker';
//
// // Locale
// import pl from 'vanillajs-datepicker/locales/pl';
// Object.assign(Datepicker.locales, pl);
//
// window.Datepicker = Datepicker

// Init
// const datepickers = document.getElementsByClassName('datepicker-widget')
//
// for (let datepicker of datepickers) {
//     new Datepicker(datepicker, {
//         language: 'pl',
//         format: 'yyyy-mm-dd'
//     });
// }

import 'flatpickr/dist/flatpickr.min.css'
import 'flatpickr/dist/themes/airbnb.css'
import flatpickr from "flatpickr";
import { Polish } from "flatpickr/dist/l10n/pl.js"

window.Flatpickr = (element, options = {}) => {
    flatpickr(element, {
        locale: Polish,
        time_24hr: true,
        dateFormat: "Y-m-d",
        altFormat: "d-m-Y",
        allowInput: true,
        minDate: '1900-01-01',
        ...options
    })
}

// const datepickers = document.getElementsByClassName('datepicker-widget')
//
// for (let datepicker of datepickers) {
//     flatpickr(datepicker, {
//         'locale': Polish
//     })
//     // new Datepicker(datepicker, {
//     //     language: 'pl',
//     //     format: 'yyyy-mm-dd'
//     // });
// }
