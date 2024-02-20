import {createApp} from "vue";
import NotificationMembersCount from "./components/NotificationMembersCount.vue";
import ConfirmationModal from "./components/ConfirmationModal.vue";
import Notification from "./components/Notification/Notification.vue";
import {Portal} from "@headlessui/vue";
import Dropdown from './components/Dropdown.vue'

const containers = document.querySelectorAll(':not(.vue-container) .vue-container')

function makeContainer(container) {
    let parent = container.parentElement
    while (parent) {
        if(parent.classList.contains('vue-container')) {
            return;
        }

        parent = parent.parentElement
    }


    createApp({
        components: {
            ConfirmationModal,
            Notification,
            HeadlessPortal: Portal,
            'd-dropdown': Dropdown
        }
    }).mount(container)
}

for (let container of containers) {
    makeContainer(container)
}

