import {defineProps} from "vue";

export const props = {
    initOptions: {
        type: Array,
        default: []
    },
    name: {
        type: String,
        default: null
    },
    value: {
        type: String,
        default: null
    },
    required: {
        type: Boolean,
        default: false
    },
    invalid: {
        type: Boolean,
        default: false
    },
    placeholder: {
        type: String,
        default: null
    }
}

export function useSelect() {
    const props = defineProps({
        initOptions: {
            type: Array,
            default: []
        },
        name: {
            type: String,
            default: null
        },
        value: {
            type: String,
            default: null
        },
        required: {
            type: Boolean,
            default: false
        },
        invalid: {
            type: Boolean,
            default: false
        },
        placeholder: {
            type: String,
            default: null
        }
    })
}

