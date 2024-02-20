import {HSOverlay} from 'preline'

function render(id, subject) {
    return `
    <div id="${id}"  class="hs-overlay w-full h-full fixed top-0 start-0 z-[60] overflow-x-hidden overflow-y-auto hidden">
        <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-white">
                        Usuwanie
                    </h3>
                    <button type="button" class="flex justify-center items-center w-7 h-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#${id}">
                        <span class="sr-only">Close</span>
                        <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto">
                    <p class="mt-1 text-gray-800 dark:text-gray-400">
                        ${subject}
                    </p>
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-700">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#${id}">
                        Nie
                    </button>
                    <button
                        data-remove
                        type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                    >
                        Tak
                    </button>
                </div>
            </div>
        </div>
    </div>
`
}


let buttons = document.querySelectorAll('[data-simple-modal]')

for (let button of buttons) {
    button.addEventListener('click', () => {

        let id = `modal` + Date.now()
        let modalTemplate = render(
            id,
            button.getAttribute('data-simple-modal')
        )

        let modalEl = document.createElement('div')
        modalEl.innerHTML = modalTemplate
        document.body.appendChild(modalEl)


        document
            .querySelectorAll(`[data-hs-overlay="#${id}"]`)
            .forEach((el) => new HSOverlay(el));
        const el = HSOverlay.getInstance('#' + id, true)

        modalEl.querySelector('[data-remove]').addEventListener('click', async () => {
            let response = await fetch(button.getAttribute('data-simple-modal-url'))

            el.element.close()

            let responseData = await response.json()

            if(response.status === 200) {

                let returnUrl = responseData.return_url || null

                if(returnUrl) {
                    window.location.href = returnUrl
                }else {
                    window.location.reload();
                }
            }else if(response.status === 400) {
                alert(responseData.message)
            }else {
                alert('Wystąpił błąd')
            }
        })

        el.element.open()

        el.element.on('close', () => {
            setTimeout(() => modalEl.remove(), 500)
        })
    })
}