<script setup>
import vSelect from 'vue-select'
import {ref} from 'vue'
import Deselect from "./Deselect.vue";

import { props as commonSelectProps } from "./select";

const props = defineProps(commonSelectProps)

const selected = ref(props.value)

let options = ref(props.initOptions)
</script>

<template>
  <input
      :name="name"
      type="hidden"
      v-model="selected"
  >

  <v-select
      :options="options"
      :components="{ Deselect }"
      :placeholder="placeholder"
      v-model="selected"
      :reduce="option => option.value"
      :class="{ 'vs--invalid': invalid }"
  >
    <template v-slot:search="{attributes, events}">
      <input
          name="test"
          class="vs__search"
          :required="required? !selected : false"
          v-bind="attributes"
          v-on="events"
      />
    </template>

    <template v-slot:no-options>
      Brak wyników
    </template>

    <template v-slot:open-indicator="{ attributes }">
      <svg :class="attributes.class" viewBox="0 0 1024 1024">
        <path fill="currentColor"
              d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"></path>
      </svg>
    </template>
  </v-select>

</template>

<style scoped>

</style>