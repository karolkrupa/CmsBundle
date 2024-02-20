<script setup>
import {ref} from "vue";
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  DialogDescription,
  TransitionRoot,
  TransitionChild
} from '@headlessui/vue'

const props = defineProps({
  successUrl: {
    type: String,
    default: ''
  }
})
const isOpen = ref(false)

function open() {
  isOpen.value = true
}

function close() {
  isOpen.value = false
}

function confirm() {
  window.location.href = props.successUrl
}
</script>

<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="close" class="relative z-50">
      <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/25"/>
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
            class="flex min-h-full items-center justify-center p-4"
        >
          <TransitionChild
              as="template"
              enter="duration-300 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
          >
            <DialogPanel
                class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-gray-800 dark:border-gray-700 md:max-w-xl md:w-full"
            >
              <div class="absolute top-2 end-2">
                <button
                    @click="close"
                    type="button"
                    class="flex justify-center items-center size-7 text-sm font-semibold rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-transparent dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
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
                    <DialogTitle
                        as="h3"
                        class="mb-2 text-xl font-bold text-gray-800 dark:text-gray-200"
                    >
                      <slot name="title"></slot>
                    </DialogTitle>

                    <p class="text-gray-500">
                      <slot name="content"></slot>
                    </p>
                  </div>
                </div>
              </div>

              <div
                  class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-gray-800 dark:border-gray-700">
                <slot name="buttons" v-bind="{ confirm, close }"></slot>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>

  <slot name="activator" v-bind="{ open }">
    <button @click="open">OPEN</button>
  </slot>
</template>

<style scoped>

</style>