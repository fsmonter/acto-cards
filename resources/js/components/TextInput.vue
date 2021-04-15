<template>
  <div>
    <label :for="name" class="block mb-1 text-sm font-semibold text-gray-700" v-if="label">{{ label }}</label>
    <input
      class="w-full px-3 py-2 text-base text-gray-800 bg-white border border-gray-300 border-solid rounded shadow-inner focus:border-green-acto focus:ring-green-acto disabled:bg-gray-300"
      :class="{ 'border-red-500': errors.length && !isDirty }"
      :type="type"
      :name="name"
      :value="value"
      :title="label"
      @input="$emit('input', $event.target.value)"
      @change="isDirty = true"
      :placeholder="placeholder"
      :disabled="disabled"
      :autocomplete="autocomplete"
    />
    <div class="h-6 pt-1 text-sm text-red-500" v-if="withErrors">
      <span v-if="errors.length && !isDirty">{{ errors[0] }}</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    type: {
      required: false,
      type: String,
      default: () => 'text'
    },
    name: {
      required: true,
      type: String
    },
    label: {
      required: false,
      type: String
    },
    withErrors: {
      required: false,
      type: Boolean,
      default: () => true
    },
    errors: {
      required: false,
      type: Array,
      default: () => []
    },
    value: {
      required: false,
      type: [String, Number, Boolean]
    },
    placeholder: {
      required: false,
      type: [String, Number]
    },
    disabled: {
      required: false,
      type: Boolean,
      default: () => false
    },
    autocomplete: {
      required: false,
      type: String,
      default: () => 'off'
    }
  },
  data() {
    return {
      isDirty: false
    }
  },
  watch: {
    errors: {
      handler(newVal, oldVal) {
        this.isDirty = false
      }
    }
  }
}
</script>
