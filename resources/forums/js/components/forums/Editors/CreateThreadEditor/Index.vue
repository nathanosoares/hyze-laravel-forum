<template>
    <div class="d-flex flex-column">
        <markdown-editor v-model="content" :configs="$simplemde.configs"></markdown-editor>
    </div>
</template>

<script>
    import MarkdownEditor from 'vue-simplemde/src/markdown-editor'

    export default {
        name: "CreateThreadEditor",
        components: {
            MarkdownEditor
        },
        data() {
            return {
                content: null
            }
        },
        mounted() {

        },
        watch: {
            content: function (val) {
                this.$emit('input', this.content)
            }
        }
    }
</script>
