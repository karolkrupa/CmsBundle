<script setup>
import {onMounted, ref} from 'vue'
import Overlay from "../components/Modal/Overlay";

const props = defineProps({
  activatorId: {
    type: String
  }
})

const sidebar = ref()
const isOpen = defineModel({default: false})

function open() {
  Overlay.show()
  sidebar.value.classList.remove('hidden')

  setTimeout(() => {
    sidebar.value.classList.add('translate-x-0')
    isOpen.value = true
  }, 10)
}

function close() {
  Overlay.hide()
  sidebar.value.classList.remove('translate-x-0')

  setTimeout(() => {
    isOpen.value = false
    sidebar.value.classList.add('hidden')
  }, 300)
}

onMounted(() => {
  document.getElementById(props.activatorId).addEventListener('click', () => {
    open()
  })

  document.body.addEventListener('click', e => {
    if (!isOpen.value) return;

    let parent = e.target

    while (parent) {
      if (parent === sidebar.value) return;

      parent = parent.parentElement
    }

    close()
  })
})
</script>

<template>
  <div ref="sidebar">
    <slot></slot>
  </div>
</template>

<style scoped>

</style>