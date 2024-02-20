import './styles/app.scss';

import '@preline/accordion'
import '@preline/dropdown'

import './js/sidebarToggle'

import './js/filepond'
import './js/datepicker'
import './js/ckeditor'

import './js/vue'

import Choices from "choices.js";
// import 'choices.js/public/assets/styles/choices.min.css'

window.Choices = Choices;


let buttons = document.querySelectorAll('[data-collection-button-add]')

for (let button of buttons) {
    button.addEventListener('click', () => {
        const containerId = button.dataset['collectionButtonAdd']

        const container = document.getElementById(containerId)

        let template = container.dataset['prototype'].replace(
            /__name__/g,
            container.dataset.index
        )

        let templateEl = document.createElement('div')
        templateEl.innerHTML = template

        container.appendChild(templateEl.firstElementChild)

        container.dataset.index++

        container.dispatchEvent(new CustomEvent('collection-add', {
            bubbles: true
        }))
    })
}

let removeButtons = document.querySelectorAll('[data-collection-button-remove]')

for (let button of removeButtons) {
    button.addEventListener('click', () => {
        const containerId = button.dataset['collectionButtonRemove']

        const container = document.getElementById(containerId)

        if (container.children.length) {
            container.children[container.children.length - 1].remove()

            container.dataset.index--

            container.dispatchEvent(new CustomEvent('collection-remove', {
                bubbles: true
            }))
        }

    })
}


// data-hs-overlay="#application-sidebar"

