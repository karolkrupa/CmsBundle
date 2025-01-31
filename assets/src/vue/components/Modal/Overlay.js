import {createApp, defineComponent, ref, h, watch, reactive, getCurrentInstance, onMounted} from "vue";

const overlayInitClasses = 'z-[100] transition duration-200 fixed inset-0 bg-gray-900 bg-opacity-50 opacity-0'.split(' ')
const transitionDuration = 200

let ModalContainer = defineComponent({
    setup(props, {expose}) {
        const overlayClasses = ref(overlayInitClasses)
        const teleportElement = ref(null)
        const active = ref(false)

        watch(active, active => {
            if (active) {
                overlayClasses.value = overlayClasses.value.filter(className => className !== 'hidden')
            } else {
                overlayClasses.value.push('hidden')
            }
        }, {immediate: true})

        function show() {
            overlayClasses.value = overlayInitClasses
            active.value = true
            setTimeout(() => overlayClasses.value = overlayClasses.value.filter(className => className !== 'opacity-0'), 10)
        }

        function hide() {
            overlayClasses.value.push('opacity-0')
            setTimeout(() => {
                active.value = false
            }, transitionDuration + 10)
        }

        expose({
            show,
            hide,
            // append,
            teleportElement
        })

        return () => {
            return h('div', {class: overlayClasses.value, ref: teleportElement})
        }
    }
})

let container = document.createElement('div')
document.body.append(container)
const modalContainer = createApp(ModalContainer)
const instance = modalContainer.mount(container)

export default instance