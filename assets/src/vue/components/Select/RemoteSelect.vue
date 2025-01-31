<script setup>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import {nextTick, ref, computed, reactive} from 'vue'
import Deselect from "./Deselect.vue";
import axios from "axios";


import {props as commonSelectProps} from "./select";

const props = defineProps({
  ...commonSelectProps,
  ...{
    value: {
      type: Object,
      default: null
    },
    remoteUrl: {
      type: String,
      default: null
    },
    pagination: {
      type: Object,
      default: {
        page: 1,
        totalPages: 1
      }
    }
  }

})

/** data **/
const selected = ref(props.value)
const pagination = reactive(props.pagination)
const options = ref(props.initOptions)
const loadMoreButton = ref(null)
let currentSearchTerm = null

/** computed **/
const hasMoreResults = computed(() => pagination.page < pagination.totalPages)
const inputValue = computed(() => {
  if (selected.value) {
    return selected.value.value
  }

  return null
})

/** methods **/
async function searchResults(text, loading) {
  if (text === '') return;

  clearTimeout(fetchTimeout)

  fetchTimeout = setTimeout(async () => {
    currentSearchTerm = text
    updateOptions(await fetch(text, 1))
    loading(false)
  }, 400)
}


async function loadNextPage() {
  if (hasMoreResults) {
    let response = await fetch(currentSearchTerm, pagination.page + 1)

    const ul = loadMoreButton.value.offsetParent
    const scrollTop = loadMoreButton.value.offsetParent.scrollTop

    updateOptions(response)

    await nextTick()
    ul.scrollTop = scrollTop
  }
}

function updateOptions(response) {
  if (response.page === 1) {
    options.value = response.data
  } else if (response.page > 1 && response.page !== pagination.page) {
    options.value = [
      ...options.value,
      ...response.data
    ]
  }

  pagination.page = response.page
  pagination.totalPages = response.total_pages
}

let fetchTimeout = null
async function fetch(text, page = 1) {
  let response = await axios.get(props.remoteUrl, {
    params: {
      search: text,
      page: page
    }
  })

  return response.data
}
</script>

<template>
  <input
      :name="name"
      type="hidden"
      :value="inputValue"
  >

  <v-select
      @search="searchResults"
      :filterable="false"
      :options="options"
      :components="{ Deselect }"
      :placeholder="placeholder"
      v-model="selected"

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

    <template v-slot:list-footer>
      <div class="text-center py-1" ref="loadMoreButton" v-if="hasMoreResults">
        <button class="text-sm text-blue-500 hover:text-blue-600" @click="loadNextPage" type="button">Zobacz więcej
        </button>
      </div>

    </template>
  </v-select>

</template>

<style scoped>

</style>