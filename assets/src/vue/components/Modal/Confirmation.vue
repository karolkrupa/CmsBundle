<script setup>
import Modal, {useModal, modalProps} from "./Modal.vue";
const {isOpen, open, close, teleportElement} = useModal()

const props = defineProps({
  ...{
    successUrl: {
      type: String,
      default: ''
    }
  },
  ...modalProps
})

function confirm() {
  window.location.href = props.successUrl
}
</script>

<template>
  <div @click="open">
    <slot>
      <button>OPEN</button>
    </slot>

    <Teleport :to="teleportElement" v-if="isOpen">
      <Modal @close="close" @confirm="confirm" v-bind="props">
        <template v-slot:title>
          <slot name="title"></slot>
        </template>

        <template v-slot:text>
          <slot name="text"></slot>
        </template>

        <template v-slot:buttons="scope">
          <slot name="buttons" v-bind="scope"></slot>
        </template>
      </Modal>
    </Teleport>
  </div>
</template>

<style scoped>

</style>