import './src/styles/app.scss';

import {createApp} from "vue";
import {namedComponents} from "./src/vue/components";
import VueClickAway from "vue3-click-away";

class CmsBundle {
    vueComponents = {};

    init() {
        this.initJs()
        this.initVue()
    }

    initJs() {
        require('./src/js')
    }

    initVue() {
        let containers = document.querySelectorAll(':not(.vue-container) .vue-container')

        for (let container of containers) {
            this.makeVueContainer(container)
        }
    }

    registerVueComponent(tag, component) {
        this.vueComponents[tag] = component
    }

    makeVueContainer(container) {
        let parent = container.parentElement
        while (parent) {
            if (parent.classList.contains('vue-container')) {
                return;
            }

            parent = parent.parentElement
        }

        createApp({
            components: this.vueComponents
        })
            .use(VueClickAway)
            .mount(container)
    }
}

const bundle = new CmsBundle()

for (const [tag, component] of Object.entries(namedComponents)) {
    bundle.registerVueComponent(tag, component)
}

export default bundle