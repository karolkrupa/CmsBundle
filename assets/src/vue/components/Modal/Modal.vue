<script>
import {ref, watch, defineComponent} from "vue";
import Overlay from "./Overlay";

/**
 * Modal composable function
 */
export const useModal = () => {
  const isOpen = ref(false)

  watch(isOpen, isOpen => {
    if (isOpen) {
      Overlay.show()
    } else {
      Overlay.hide()
    }
  })

  function open() {
    isOpen.value = true
  }

  function close() {
    isOpen.value = false
  }

  return {
    isOpen,
    open,
    close,
    teleportElement: Overlay.teleportElement
  }
}

export const modalProps = {
  confirmText: {
    type: String,
    default: 'Tak'
  },
  rejectText: {
    type: String,
    default: 'Nie'
  },
  title: {
    type: String,
    default: ''
  },
  text: {
    type: String,
    default: ''
  }
}

/**
 * Modal view component
 */
export default defineComponent({
  props: modalProps,
  emits: ['confirm', 'close'],
  setup(props, {emit}) {
    function close() {
      emit('close')
    }

    function confirm() {
      emit('confirm')
    }

    return {
      close,
      confirm
    }
  }
})
</script>

<template>
  <div
      class="flex min-h-full items-center justify-center p-4"
  >
    <div
        class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden md:max-w-xl md:w-full"
    >
      <div class="absolute top-2 end-2">
        <button
            @click="close"
            type="button"
            class="flex justify-center items-center size-7 text-sm font-semibold rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
        >
          <span class="sr-only">Close</span>
          <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
               viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
               stroke-linejoin="round">
            <path d="M18 6 6 18"/>
            <path d="m6 6 12 12"/>
          </svg>
        </button>
      </div>


      <div class="p-4 sm:p-6 overflow-y-auto">
        <div class="flex gap-x-4 md:gap-x-7">
          <div class="grow">
            <h3
                class="mb-2 text-xl font-bold text-gray-800"
            >
              <slot name="title">{{ title }}</slot>
            </h3>

            <slot name="content">
              <p class="text-sm text-gray-500">
                <slot name="text">{{ text }}</slot>
              </p>
            </slot>
          </div>
        </div>
      </div>

      <div
          class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-gray-800 dark:border-gray-700">
        <slot name="buttons" v-bind="{ confirm, close }">
          <button
              @click="confirm"
              type="button"
              class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            {{ confirmText }}
          </button>

          <button
              @click="close"
              type="button"
              class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
            {{ rejectText }}
          </button>
        </slot>
      </div>
    </div>

  </div>
</template>