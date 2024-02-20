<script setup>
import {onMounted, ref} from "vue";

const props = defineProps({
  type: {
    type: String,
    default: 'info'
  },
  autoClose: {
    type: Boolean,
    default: true
  },
  autoCloseDelay: {
    type: Number,
    default: 5000
  }
})

const rootEl = ref()

const typeBg = {
  info: 'bg-white',
  success: 'bg-green-50',
  error: 'bg-red-100',
  warning: 'bg-yellow-50',
}

const typeIconColor = {
  info: 'text-blue-600',
  success: 'text-green-600',
  error: 'text-red-600',
  warning: 'text-yellow-600',
}

function close() {
  rootEl.value.classList.add('opacity-0')

  setTimeout(() => {
    rootEl.value.remove()
  }, 160)

}

onMounted(() => {
  if(props.autoClose) {
    setTimeout(close, props.autoCloseDelay)
  }

  setTimeout(() => {
    rootEl.value.classList.remove('opacity-0')
  }, 0)
})

</script>

<template>
  <div ref="rootEl" :class="typeBg[type]"
       class="shadow rounded-lg p-4 min-w-[250px] opacity-0 transition-opacity duration-150 ease-in-out"
       role="alert">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg :class="typeIconColor[type]" class="flex-shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg"
             width="24"
             height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <path d="M12 16v-4"/>
          <path d="M12 8h.01"/>
        </svg>
      </div>
      <div class="ms-3 w-full">
        <div class="flex justify-between items-center w-full">
          <h3 class="text-gray-800 text-sm font-medium dark:text-white">
            <slot name="title"></slot>
          </h3>

          <button class="hover:opacity-50" @click="close">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                 class="ml-2 size-4" :class="typeIconColor[type]">
              <path
                  d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"></path>
            </svg>
          </button>

        </div>

        <p class="mt-2 text-xs text-gray-700 dark:text-gray-400">
          <slot name="content"></slot>
        </p>
      </div>
    </div>

  </div>

</template>

<style scoped>

</style>