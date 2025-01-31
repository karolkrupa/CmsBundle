let buttons = document.querySelectorAll('[data-collection-button-add]')

function executeScriptElements(containerElement) {
    console.log(containerElement)
    const scriptElements = containerElement.querySelectorAll("script");

    Array.from(scriptElements).forEach((scriptElement) => {
        const clonedElement = document.createElement("script");

        Array.from(scriptElement.attributes).forEach((attribute) => {
            clonedElement.setAttribute(attribute.name, attribute.value);
        });

        clonedElement.text = scriptElement.text;

        scriptElement.parentNode.replaceChild(clonedElement, scriptElement);
    });
}

for (let button of buttons) {
    button.addEventListener('click', () => {
        const containerId = button.dataset['collectionButtonAdd']

        const container = document.getElementById(containerId)

        let template = container.dataset['prototype'].replace(
            /__name__label__/g,
            container.dataset.index
        )

        template = template.replace(
            /__name__/g,
            container.dataset.index
        )

        let templateEl = document.createElement('div')
        templateEl.innerHTML = template

        container.appendChild(templateEl)

        executeScriptElements(templateEl)

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
