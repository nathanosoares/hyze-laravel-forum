<template>
  <div class>
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
            <user-avatar :user="post.author" size="s" class="mr-2 rounded"/>

            <div>
              <user-twitter-anchor :user="post.author">{{ post.author.nick }}</user-twitter-anchor>
              <span class="text-muted">&#183; {{ moment(post.created_at).fromNow() }}</span>
            </div>
          </div>

          <div class="position-relative">
            <div class="dropdown float-right" style="right: 0;" v-if="canEdit() || canDestroy()">
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

            <div v-else v-html="post.body_parsed" class="w-100 post-content"></div>
          </div>

          <div class="mt-auto">
            <div class="mt-3 d-flex flex-row align-items-end">
              <div>
                <button
                  type="button"
                  v-if="post.replies.length > 0 && canShowReplies"
                  class="btn btn-danger rounded-pill"
                  @click.prevent.stop="canShowReplies = false"
                >
                  Ocultar respostas
                  <i class="fas fa-angle-up align-middle ml-1"></i>
                </button>

                <button
                  type="button"
                  v-if="hasMoreReplies && canShowReplies && post.replies.length == 0"
                  class="btn btn-secondary rounded-pill"
                  @click.prevent.stop="loadMoreReplies"
                  v-html="showMoreText"
                >{{ showMoreText }}</button>

                <button
                  type="button"
                  v-if="post.replies.length > 0 && !canShowReplies"
                  class="btn btn-secondary rounded-pill"
                  @click.prevent.stop="canShowReplies = true"
                >
                  Mostrar {{ post.replies.length }} respostas
                  <i
                    class="fas fa-angle-down align-middle ml-1"
                  ></i>
                </button>

                <button
                  type="button"
                  class="btn btn-primary rounded-pill"
                  v-if="canReply()"
                  @click.prevent.stop="doReply"
                >
                  <span v-if="responding">
                    <i class="fas fa-comment-slash fa-fw"></i> Responder
                  </span>
                  <span v-else>
                    <i class="fas fa-comment fa-fw"></i> Responder
                  </span>
                </button>
              </div>

              <div class="ml-auto d-none d-lg-block">
                <small class="font-weight-lighter mr-2" v-if="thread.main_post.id == post.id">
                  <i class="far fa-comment-dots fa-fw"></i>
                  {{ thread.replies_count }} respostas
                </small>

                <small class="font-weight-lighter">
                  <i class="fas fa-clock fa-fw"></i>
                  <time
                    :datetime="moment(post.created_at).format()"
                  >{{ moment(post.created_at).fromNow() }}</time>
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-10 ml-lg-auto">
        <div class="d-flex flex-column mb-3">
          <div v-show="canShowReplies">
            <reply-item
              class="my-3"
              v-for="reply in orderedReplies"
              :reply="reply"
              :key="reply.id"
            />
          </div>

          <div v-if="loadingReplies" class="text-center">
            <i class="fas fa-circle-notch fa-spin"></i>
          </div>

          <div>
            <button
              v-if="hasMoreReplies && canShowReplies &&  post.replies.length > 0"
              href="#"
              class="btn btn-secondary btn-sm rounded-pill"
              @click.prevent.stop="loadMoreReplies"
              v-html="showMoreText"
            >{{ showMoreText }}</button>
          </div>
        </div>

        <div v-show="canReply() && responding">
          <div class="d-flex text-break w-100 my-4">
            <user-avatar :user="$user" size="s" :classes="['rounded', 'flex-shrink-0']"></user-avatar>

            <create-reply-editor
              v-if="responding"
              class="w-100 ml-3 text-break"
              :post="post"
              v-on:cancel="responding = false"
              v-on:success="responding = false"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ReplyItem from "../ReplyItem/Index";
import AuthorCardNormal from "@components/forums/AuthorCard/Normal";
import UserAvatar from "@components/UserAvatar";
import AuthorCardSmall from "@components/forums/AuthorCard/Small";
import CreatePostEditor from "@components/forums/Editors/CreatePostEditor/Index";
import EditPostEditor from "@components/forums/Editors/EditPostEditor/Index";
import CreateReplyEditor from "@components/forums/Editors/CreateReplyEditor/Index";
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
      return [...this.post.replies].sort((a, b) =>
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
      this.$store
        .dispatch(actions.DELETE_POST, { post: this.post })
        .then(response => {
          if (
            response.status == 204 &&
            this.thread.main_post.id === this.postId
          ) {
            window.location.href = this.route(
              "forums.forum",
              [this.thread.forum.slug, this.thread.forum.id]
            );
          }
        });
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
      return this.$gate.allow("destroy", "post", this.post);
    },
    canEdit: function() {
      return this.$gate.allow("edit", "post", this.post);
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