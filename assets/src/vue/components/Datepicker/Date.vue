<script setup>
import VueDatePicker from '@vuepic/vue-datepicker'
import {ref, computed} from "vue";

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  value: {
    type: String,
    required: false,
    default: null
  },
  invalid: {
    type: Boolean,
    default: false
  },
  time: {
    type: Boolean,
    default: false
  },
  monthPicker: {
    type: Boolean,
    default: false
  }
})

const input = ref()
let date = ref(props.value)
const state = computed(() => props.invalid ? false : null)
const modelFormat = computed(() => {
  if(props.monthPicker) {
    return 'yyyy-MM'
  }

  if (props.time) {
    return 'yyyy-MM-dd HH:mm'
  }

  return 'yyyy-MM-dd'
})
const enableTimePicker = computed(() => !props.monthPicker && props.time)

function onModelValueUpdate(e) {
  input.value.dispatchEvent(new InputEvent('input', {
    bubbles: true,
    data: date.value
  }))
}

</script>

<template>
  <!-- HTML Event input -->
  <input style="display: none" type="hidden" ref="input">
  <VueDatePicker
      :is-24="true"
      :teleport="true"
      :state="state"
      :name="name"
      :format="modelFormat"
      :enable-time-picker="enableTimePicker"
      v-model="date"
      @update:model-value="onModelValueUpdate"
      :model-type="modelFormat"
      :month-picker="monthPicker"
      locale="pl-PL"
      select-text="Wybierz"
      cancel-text="Anuluj"
  />
</template>

<style scoped>

</style>