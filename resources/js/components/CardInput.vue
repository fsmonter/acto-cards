<template>
  <div>
    <input ref="input" :value="value" @keydown="addCard" />
  </div>
</template>

<script>
export default {
  props: ['value'],
  methods: {
    addCard(e) {
      return this.$emit('input', e.target.value)
    },
  },
}
</script>

<style></style>
