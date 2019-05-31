<template>
  <div class="d-flex flex-column">
    <markdown-editor v-model="value" :configs="$simplemde.configs"></markdown-editor>
  </div>
</template>

<script>
import MarkdownEditor from "vue-simplemde/src/markdown-editor";

export default {
  name: "CreateThreadEditor",
  components: {
    MarkdownEditor
  },
  props: ["value"],
  data() {
    return {
      content: null
    };
  },
  mounted() {
    // console.log(this.value);
    // this.content = ;
  },
  watch: {
    value: function(val) {
      this.$emit("input", this.value);
    }
  }
};
</script>
