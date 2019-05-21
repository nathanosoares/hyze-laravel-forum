<template>
  <div class="py-4">
    <div class="row mb-3">
      <div class="d-none d-lg-block col-lg-2">
        <author-card-normal :author="post.author"></author-card-normal>
      </div>

      <div class="d-flex d-lg-block col-lg-10">
        <div
          class="shadow-sm rounded bg-white h-100 p-3 d-flex flex-column w-100"
          :id="'post-' + post.id"
        >
          <div class="d-lg-none d-flex mb-2">
            <user-avatar :user="post.author" size="s" class="mr-2"/>

            <div>
              <user-twitter-anchor :user="post.author">{{ post.author.nick }}</user-twitter-anchor>
              <span class="text-muted">&#183; {{ moment(post.created_at).fromNow() }}</span>
            </div>
          </div>

          <div class="position-relative">
            <div
              class="dropdown float-right"
              style="right: 0;"
              v-if="canEdit() || canDestroy()"
            >
              <button
                class="btn btn-sm"
                type="button"
                :id="`dropdownMenuButton${post.id}`"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <div
                class="dropdown-menu dropdown-menu-right"
                :aria-labelledby="`dropdownMenuButton${post.id}`"
              >
                <a
                  class="dropdown-item"
                  href="#"
                  @click.prevent.stop="toggleEditMode($event)"
                  v-if="canEdit()"
                >
                  <i class="far fa-edit"></i> Editar
                </a>

                <a
                  class="dropdown-item"
                  href="#"
                  @click.stop.prevent="tryDestroyPost"
                  v-if="canDestroy()"
                >
                  <i class="far fa-trash-alt"></i> Excluir
                </a>
              </div>
            </div>

            <div v-if="editable">
              <span>&nbsp;</span>
              <edit-post-editor
                v-if="editable"
                class="w-100 my-3"
                :post="post"
                :content="post.body"
                v-on:cancel:edit="editable = false"
                v-on:success:edit="editable = false"
              />
            </div>

            <div v-else v-html="post.body_parsed" class="w-100"></div>
          </div>

          <div class="mt-auto">
            <div class="mt-3 d-flex flex-row align-items-end">
              <small class="ml-auto font-weight-lighter d-none d-lg-block">
                <i class="fas fa-clock mr-1"></i>
                <time
                  :datetime="moment(post.created_at).format()"
                >{{ moment(post.created_at).fromNow() }}</time>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-10 ml-lg-auto">
        <!--<div v-if="post.replies_count > 0 || post.replies.length > 0" class="d-flex flex-column mb-3">-->
        <div class="d-flex flex-column mb-3">
          <a
            v-if="post.replies.length > 0 && canShowReplies"
            href="#"
            class="font-weight-bold text-primary"
            @click.prevent.stop="canShowReplies = false"
          >
            Ocultar respostas
            <i class="fas fa-angle-up align-middle ml-1"></i>
          </a>

          <reply-item
            v-if="canShowReplies"
            class="my-3"
            v-for="reply in orderedReplies"
            :reply="reply"
            :key="reply.id"
          />

          <div v-if="loadingReplies" class="text-center">
            <i class="fas fa-circle-notch fa-spin"></i>
          </div>

          <a
            v-if="hasMoreReplies && canShowReplies"
            href="#"
            class="font-weight-bold text-primary"
            @click.prevent.stop="loadMoreReplies"
            v-html="showMoreText"
          >{{ showMoreText }}</a>

          <a
            v-if="post.replies.length > 0 && !canShowReplies"
            href="#"
            class="font-weight-bold text-primary"
            @click.prevent.stop="canShowReplies = true"
          >
            Mostrar {{ post.replies.length }} respostas
            <i
              class="fas fa-angle-down align-middle ml-1"
            ></i>
          </a>
        </div>

        <template v-if="canReply()">
          <div v-if="responding" class="d-flex my-4">
            <user-avatar :user="$user" size="s"></user-avatar>
            <create-reply-editor
              class="w-100 ml-3"
              :post="post"
              v-on:cancel="responding = false"
              v-on:success="responding = false"
            />
          </div>

          <button
            href="#"
            class="btn btn-primary rounded-pill"
            v-if="!responding"
            @click.prevent.stop="doReply"
          >
            <i class="fas fa-comment"></i> Responder
          </button>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import ReplyItem from "./ReplyItem/Index";
import AuthorCardNormal from "@components/chatter/AuthorCard/Normal";
import UserAvatar from "@components/UserAvatar";
import AuthorCardSmall from "@components/chatter/AuthorCard/Small";
import CreatePostEditor from "@components/chatter/Editors/CreatePostEditor/Index";
import EditPostEditor from "@components/chatter/Editors/EditPostEditor/Index";
import CreateReplyEditor from "@components/chatter/Editors/CreateReplyEditor/Index";
import * as actions from "@store/action-types";

export default {
  name: "PostItem",
  components: {
    ReplyItem,
    AuthorCardNormal,
    UserAvatar,
    AuthorCardSmall,
    CreatePostEditor,
    EditPostEditor,
    CreateReplyEditor
  },
  props: {
    postId: {
      type: Number,
      required: true
    },
    thread: {
      type: Object,
      required: true
    }
  },
  computed: {
    post: function() {
      return this.$store.getters.postById(this.postId);
    },
    showMoreText: function() {
      if (this.post.replies.length === 0) {
        return (
          "Mostrar " +
          this.post.replies_count +
          ' respostas <i class="fas fa-angle-down align-middle ml-1"></i>'
        );
      }

      return 'Mostrar mais respostas <i class="fas fa-angle-down align-middle ml-1"></i>';
    },
    orderedReplies: function() {
      let self = this;
      return this.post.replies.sort((a, b) =>
        self.moment(a.created_at).diff(self.moment(b.created_at))
      );
    }
  },
  mounted() {
    this.hasMoreReplies = this.post.replies_count > 0;
  },
  data() {
    return {
      responding: false,
      repliesLimit: 1,
      hasMoreReplies: false,
      canShowReplies: true,
      repliesPage: 1,
      loadingReplies: false,
      editable: false
    };
  },
  methods: {
    tryDestroyPost: function() {
      this.$store.dispatch(actions.DELETE_POST, { post: this.post });
    },
    loadMoreReplies: function() {
      this.loadingReplies = true;

      this.$store
        .dispatch(actions.FETCH_REPLIES, {
          post: this.post,
          page: this.repliesPage
        })
        .then(response => {
          this.loadingReplies = false;
          this.repliesPage++;
          this.hasMoreReplies =
            response.data.current_page < response.data.last_page;
        });
    },
    doReply: function() {
      if (this.thread.main_post.id !== this.post.id) {
        this.responding = !this.responding;
      } else {
        this.$scrollTo("#reply__thread__" + this.thread.id);
        $("#reply__thread__" + this.thread.id + " .ProseMirror").focus();
      }
    },
    canReply: function() {
      return (
        this.$gate.allow("reply", "post", this.post) &&
        this.$gate.allow("write", "forum", this.thread.forum)
      );
    },
    canDestroy: function() {
      return (
        this.$gate.allow("destroy", "post", this.post) &&
        this.$gate.allow("write", "forum", this.thread.forum)
      );
    },
    canEdit: function() {
      return (
        this.$gate.allow("edit", "post", this.post) &&
        this.$gate.allow("write", "forum", this.thread.forum)
      );
    },
    toggleEditMode: function($event) {
      $($event.target)
        .closest(".dropdown-menu")
        .prev()
        .dropdown("toggle");

      this.editable = true;
    }
  }
};
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