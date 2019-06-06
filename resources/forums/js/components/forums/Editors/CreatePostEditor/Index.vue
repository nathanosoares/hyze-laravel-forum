<template>
    <div class="d-flex flex-column">
        <markdown-editor v-model="content" :configs="$simplemde.configs"></markdown-editor>

        <button class="btn btn-secondary rounded-pill ml-auto mt-4" :disabled="!canSubmit || sending" @click="tryReplyThread">
            Responder
        </button>
    </div>
</template>

<script>
    import MarkdownEditor from 'vue-simplemde/src/markdown-editor'
    import * as actions from '@store/action-types'

    export default {
        name: "CreatePostEditor",
        props: {
            thread: {
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
                canSubmit: false,
                sending: false
            }
        },
        watch: {
            content: function (value) {
                this.updateCanSubmit();
            }
        },
        methods: {
            updateCanSubmit() {
                this.canSubmit = this.content.length >= 2 && !this.sending
            },
            tryReplyThread: function () {
                this.sending = true;

                this.$store.dispatch(actions.CREATE_POST, {
                    thread: this.thread,
                    body: this.content
                }).then((response) => {
                    this.sending = false
                    this.content = ''
                    this.$emit('success', response)
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .editor {
        border: 1px solid #302f2c;
        overflow: hidden;

        .menubar {
            background: #0c1523;
            border-bottom: 1px solid #302f2c;
        }

        .menubar__button {
            display: inline-block;
            text-align: center;
            text-decoration: none !important;
            color: #b7cedd !important;
            margin: 0;
            border: 1px solid transparent;
            border-radius: 3px;
            width: 30px;
            cursor: pointer;
            font-size: 1.2em;
            line-height: 1.2em;

            &:hover,
            &.is-active {
                border-color: #ab8742;
            }
        }
    }
</style>