<script setup>
import {Popover, PopoverButton, PopoverPanel} from '@headlessui/vue'
import {ChevronDownIcon} from '@heroicons/vue/20/solid'

const props = defineProps({
  activatorClass: {
    type: String,
    default: ''
  },
  panelClass:{
    type: String,
    default: ''
  }
})


</script>

<template>
    <Popover v-slot="{ open }" class="">
      <PopoverButton
          as="button"
          class="flex justify-center items-center size-7 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
          :class="activatorClass"
      >
        <slot name="activator"></slot>
      </PopoverButton>

      <transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="translate-y-1 opacity-0"
          enter-to-class="translate-y-0 opacity-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="translate-y-0 opacity-100"
          leave-to-class="translate-y-1 opacity-0"
      >
        <PopoverPanel
            class="absolute z-10 min-w-60 bg-white shadow-md rounded-lg p-2 mt-2 flex flex-col"
            :class="panelClass"
        >
          <slot></slot>
        </PopoverPanel>
      </transition>
    </Popover>



</template>

<style scoped>

</style>