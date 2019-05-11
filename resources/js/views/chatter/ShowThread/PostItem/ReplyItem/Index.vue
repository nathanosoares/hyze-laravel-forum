<template>
    <div class="d-flex mb-2" :id="'reply__' + reply.id">
        <user-avatar :user="reply.author" size="s"/>

        <div class="ml-3 bg-white shadow-sm rounded w-100 p-3 d-flex flex-column">
            <div>
                <span class="font-weight-light">{{ reply.author.name }} <span class="text-muted">(@{{ reply.author.username }})</span> disse:</span>

                <edit-post-editor v-if="editable" class="w-100 mb-3" :post="reply" :content="reply.body"
                                  v-on:cancel:edit="editable = false"
                                  v-on:success:edit="editable = false"
                                  v-on:update:post="$emit('update:post', $event)"/>


                <div v-else v-html="reply.body_parsed"></div>
            </div>

            <div class="mt-auto">
                <div class="d-flex flex-row align-items-end">
                    <small class="font-weight-lighter">
                        <i class="far fa-clock mr-2"></i><time :datetime="moment(reply.created_at).format()">{{ moment(reply.created_at).fromNow() }}</time>
                    </small>

                    <div class="ml-auto">
                        <a class="btn btn-ghost btn-sm" href="#"
                           @click.stop.prevent="toggleEditMode($event)"
                           v-if="$gate.allow('edit', 'post', reply)">
                            <i class="far fa-edit"></i> Editar
                        </a>

                        <a class="btn btn-ghost btn-sm" href="#"
                           @click.stop.prevent="tryDeletePost"
                           v-if="$gate.allow('destroy', 'post', reply)">
                            <i class="far fa-trash-alt"></i> Excluir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EditPostEditor from '@components/chatter/Editors/EditPostEditor/Index'
    import * as actions from '@store/action-types'

    export default {
        name: "ReplyItem",
        components: {
            EditPostEditor
        },
        props: {
            reply: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                editable: false
            }
        },
        methods: {
            tryDeletePost: function () {
                this.$store.dispatch(actions.DELETE_POST, {post: this.reply})
            },
            toggleEditMode: function ($event) {
                $('#settings__post__' + this.reply.id).dropdown('toggle')
                $('#reply__' + this.reply.id + ' .ProseMirror').focus()

                this.editable = true
            }
        }
    }
</script>

<style scoped>

</style>