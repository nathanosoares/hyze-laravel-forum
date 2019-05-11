<template>
    <div class="d-flex flex-column">
        <markdown-editor class="edit-post-editor" v-model="content" :configs="$simplemde.configs"></markdown-editor>

        <div class="mt-2 mx-2 d-flex">
            <div class="ml-auto">
                <a class="btn btn-custom-secondary btn-sm"
                   @click.stop.prevent="$emit('cancel:edit')">
                    Cancelar
                </a>

                <a class="btn btn-custom-primary btn-sm" :disabled="sending || !canSubmit"
                   @click.stop.prevent="tryEditPost">
                    Salvar alterações
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import MarkdownEditor from 'vue-simplemde/src/markdown-editor'
    import * as actions from '@store/action-types'

    export default {
        name: "EditPostEditor",
        props: {
            post: {
                type: Object,
                required: true
            }
        },
        components: {
            MarkdownEditor
        },
        data() {
            return {
                content: null,
                canSubmit: false,
                sending: false,
            }
        },
        mounted() {
            this.content = this.post.body
        },
        methods: {
            updateCanSubmit() {
                this.canSubmit = this.content.length >= 2
            },
            tryEditPost: function () {

                let self = this
                this.sending = true
                this.$store.dispatch(actions.UPDATE_POST, {post: this.post, body: this.content})
                    .then(() => {
                        self.$emit('success:edit')
                    })
            }
        }
    }
</script>

<style>
    .edit-post-editor .CodeMirror,
    .edit-post-editor .CodeMirror-scroll {
        min-height: 100px;
    }
</style>