import ConfirmationModal from "./Modal/Confirmation.vue";
import Notification from "./Notification/Notification.vue";
import Dropdown from './Dropdown.vue'
import RemoteSelect from "./Select/RemoteSelect.vue";
import Select from "./Select/Select.vue";
import Datepicker from "./Datepicker/Date.vue";
import SidebarDropdown from "../layout/SidebarDropdown.vue";
import Sidebar from "../layout/Sidebar.vue";

export default {
    ConfirmationModal,
    Notification,
    Dropdown
}

export {ConfirmationModal};
export {Notification};
export {Dropdown};

export const namedComponents = {
    'd-confirmation-modal': ConfirmationModal,
    'd-notification': Notification,
    'd-dropdown': Dropdown,
    'd-remote-select': RemoteSelect,
    'd-select': Select,
    'd-datepicker': Datepicker,
    'd-sidebar': Sidebar,
    'd-sidebar-dropdown': SidebarDropdown
}