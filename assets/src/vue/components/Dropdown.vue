<script setup>
import {nextTick, ref} from 'vue'

const isOpen = defineModel({default: false})
const closeAwayActive = ref(false)

import {useFloating, autoUpdate, autoPlacement, shift} from '@floating-ui/vue';

const button = ref(null);
const floating = ref(null);
const {floatingStyles} = useFloating(button, floating, {
  transform: false,
  whileElementsMounted: autoUpdate,
  // placement: 'bottom',
  middleware: [shift()]
});

function open() {
  isOpen.value = true

  setTimeout(() => {
    closeAwayActive.value = true
  }, 0)
}

function close() {
  isOpen.value = false
  closeAwayActive.value = false
}

function toggle() {
  if (!isOpen.value) {
    open()
  } else {
    close()
  }
}

function clickAway() {
  if (isOpen.value && closeAwayActive.value) {
    close()
  }
}

</script>

<template>
  <div class="flex" ref="button" @click="toggle">
    <slot></slot>
  </div>

  <Teleport to="body" :disabled="!isOpen">
    <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="translate-y-1 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-1 opacity-0"
    >
      <div
          ref="floating"
          v-click-away="clickAway"
          v-show="isOpen"
          class="absolute z-10 min-w-60"
          :style="floatingStyles"
      >
        <slot name="content"></slot>
      </div>

    </transition>
  </Teleport>
</template>

<style scoped>

</style>