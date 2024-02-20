<script setup>
import {ref, defineProps} from "vue";
import axios from "axios";

const props = defineProps([
  'endpoint',
  'formName',
  'requirementsContainer',
  'initialAmount',
  'object',
  'type'
])

let count = ref(props.initialAmount || 0)

const requirementsContainer = document.getElementById(props.requirementsContainer)

let form = requirementsContainer.parentElement
while (!['form', 'body'].includes(form.nodeName.toLowerCase())) {
  form = form.parentElement
}

if (form.nodeName.toLowerCase() === 'form' && requirementsContainer) {
  let debounce = null;

  async function fetchCnt() {
    let formData = new FormData(form)
    let newData = new FormData()
    for (let part of formData.entries()) {
      if (part[0].startsWith(`${props.formName}[requirements]`)) {

        newData.append(`requirements${part[0].substr((`${props.formName}[requirements]`).length)}`, part[1])
      }
    }

    newData.append('object', props.object)
    newData.append('type', props.type)

    let response = await axios.postForm(props.endpoint, newData)

    count.value = response.data.cnt || 0
  }

  requirementsContainer.addEventListener('input', () => {
    clearTimeout(debounce)
    debounce = setTimeout(fetchCnt, 500)
  })

  requirementsContainer.addEventListener('collection-add', () => {
    clearTimeout(debounce)
    debounce = setTimeout(fetchCnt, 500)
  })

  requirementsContainer.addEventListener('collection-remove', () => {
    clearTimeout(debounce)
    debounce = setTimeout(fetchCnt, 500)
  })
}
</script>

<template>
  <span class="text-sm">
    Przewidywana liczba uczestników: <b>{{ count }}</b>
  </span>

</template>

<style scoped>

</style>