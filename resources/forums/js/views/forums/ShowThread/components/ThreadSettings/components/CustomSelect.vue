<template>
  <div>
    <label :for="`custom-select-${_uid}`">{{ label }}</label>
    <select class="custom-select" :id="`custom-select-${_uid}`" @change="change">
      <option
        v-for="option in options"
        :key="option.value"
        :value="option.value"
        :selected="value != null && option.value == value"
      >{{ option.label }}</option>
    </select>
  </div>
</template>


<script>
export default {
  name: "CustomSwitch",
  props: {
    label: {
      type: String,
      required: true
    },
    value: {
      type: String,
      default: null
    },
    options: {
      type: Array,
      default: () => []
    }
  },
  data: function() {
    return {
      selected: this.value
    };
  },
  methods: {
    change(event) {
      this.$emit("input", event.target.value);
    }
  }
};
</script>

