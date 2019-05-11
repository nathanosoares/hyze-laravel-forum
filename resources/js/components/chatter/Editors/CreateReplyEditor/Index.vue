<template>
    <div class="d-flex flex-column">
        <div class="rounded position-relative">
            <markdown-editor class="reply-editor" v-model="content" :configs="$simplemde.configs"></markdown-editor>
        </div>

        <div class="mt-2 mx-2 d-flex">
            <div class="ml-auto">
                <a class="btn btn-custom-secondary btn-sm"
                   @click.stop.prevent="$emit('cancel')">
                    Cancelar
                </a>

                <a class="btn btn-custom-primary btn-sm" :disabled="!canSubmit"
                   @click.stop.prevent="tryReplyPost">
                    Responder
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import MarkdownEditor from 'vue-simplemde/src/markdown-editor'
    import * as actions from '@store/action-types'

    export default {
        name: "ReplyPostEditor",
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
                content: '',
                canSubmit: false
            }
        },
        methods: {
            updateCanSubmit() {
                this.canSubmit = this.content.length >= 2
            },
            tryReplyPost: function () {
                let self = this

                this.$store.dispatch(actions.CREATE_POST, {
                    parent: this.post,
                    body: this.content
                }).then((response) => {
                    this.content = ''
                    self.$emit('success', response)
                })
            }
        }
    }
</script>

<style>
    .reply-editor .CodeMirror,
    .reply-editor .CodeMirror-scroll {
        min-height: 100px;
    }
</style>