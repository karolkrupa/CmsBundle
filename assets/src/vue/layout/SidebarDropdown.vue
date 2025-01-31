<script setup>
import {ref, watch} from 'vue'

const isOpen = defineModel('isOpen', {default: false})
const element = ref()

watch(isOpen, value => {
  if(value) {
    element.value.querySelector('.dropdown-content').classList.remove('hidden')
  }else {
    element.value.querySelector('.dropdown-content').classList.add('hidden')
  }
})

function toggle() {
  isOpen.value = !isOpen.value
}
</script>

<template>
  <div ref="element">
    <slot v-bind="{ isOpen, toggle }"></slot>
  </div>
</template>

<style scoped>

</style>