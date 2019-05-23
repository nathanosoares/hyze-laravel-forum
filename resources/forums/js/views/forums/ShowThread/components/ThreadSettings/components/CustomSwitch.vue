<template>
  <div class="custom-control custom-switch">
    <input
      :checked="checked"
      @change="change"
      type="checkbox"
      class="custom-control-input"
      :id="`custom-switch-${_uid}`"
    >
    <label class="custom-control-label" :for="`custom-switch-${_uid}`">{{ label }}</label>
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
      type: Boolean,
      default: false
    }
  },
  data: function() {
    return {
      checked: this.value
    };
  },
  methods: {
    change() {
      this.checked = !this.checked;
      this.$emit("input", this.checked);
    }
  }
};
</script>
