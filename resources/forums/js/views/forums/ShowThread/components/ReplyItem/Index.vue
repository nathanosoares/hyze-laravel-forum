<template>
  <div class="d-flex">
    <div class="mr-3">
      <user-avatar :user="reply.author" size="80px" :classes="['rounded', 'flex-shrink-0']"/>
    </div>
    <div class="d-flex text-break w-100">
      <div
        class="shadow-sm rounded bg-white h-100 p-3 d-flex flex-column w-100"
        :id="'reply__' + reply.id"
      >
        <div class="position-relative">
          <div
            class="float-right"
            style="right: 0;"
            v-if="$gate.allow('edit', 'post', reply) || $gate.allow('destroy', 'post', reply)"
          >
            <button
              class="btn btn-sm"
              type="button"
              :id="`dropdownMenuButton-${reply.id}`"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="fas fa-ellipsis-v"></i>
            </button>
            <div
              class="dropdown-menu dropdown-menu-right"
              :aria-labelledby="`dropdownMenuButton-${reply.id}`"
            >
              <a
                href="#"
                class="dropdown-item"
                @click.stop.prevent="toggleEditMode($event)"
                v-if="$gate.allow('edit', 'post', reply)"
              >
                <i class="far fa-edit"></i> Editar
              </a>

              <a
                href="#"
                class="dropdown-item"
                @click.stop.prevent="tryDeletePost($event)"
                v-if="$gate.allow('destroy', 'post', reply)"
              >
                <i class="far fa-trash-alt"></i> Excluir
              </a>
            </div>
          </div>

          <span class="font-weight-light">{{ reply.author.nick }} disse:</span>

          <edit-post-editor
            v-if="editable"
            class="w-100 mb-3 mt-3"
            :post="reply"
            :content="reply.body"
            v-on:cancel:edit="editable = false"
            v-on:success:edit="editable = false"
            v-on:update:post="$emit('update:post', $event)"
          />

          <div v-else v-html="reply.body_parsed"></div>
        </div>

        <div class="mt-auto">
          <div class="mt-3 d-flex flex-row align-items-end">
            <small class="ml-auto font-weight-lighter">
              <i class="fas fa-clock mr-1"></i>
              <time
                :datetime="moment(reply.created_at).format()"
              >{{ moment(reply.created_at).fromNow() }}</time>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EditPostEditor from "@components/forums/Editors/EditPostEditor/Index";
import * as actions from "@store/action-types";

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
    };
  },
  methods: {
    tryDeletePost: function($event) {
      $($event.target)
        .closest(".dropdown-menu")
        .prev()
        .dropdown("toggle");

      this.$store.dispatch(actions.DELETE_POST, { post: this.reply });
    },
    toggleEditMode: function($event) {
      $($event.target)
        .closest(".dropdown-menu")
        .prev()
        .dropdown("toggle");

      $("#settings__post__" + this.reply.id).dropdown("toggle");
      $("#reply__" + this.reply.id + " .ProseMirror").focus();

      this.editable = true;
    }
  }
};
</script>

<style scoped>
</style>