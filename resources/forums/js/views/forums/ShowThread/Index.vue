<template>
  <div class="thread-wrapper">
    <div class="thread-header mt-2 mb-4">
      <div class="collapse" :id="'thread-options-collapse-' + thread.id">
        <div class="bg-white shadow-sm rounded p-4 mb-4">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitch1" :checked="thread.promoted">
            <label class="custom-control-label" for="customSwitch1">Promover para home</label>
          </div>

          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitch1" :checked="thread.sticky">
            <label class="custom-control-label" for="customSwitch1">Fixar no topo</label>
          </div>
        </div>
      </div>

      <div class="float-right">
        <button
          class="btn shadow-none"
          type="button"
          data-toggle="collapse"
          :data-target="'#thread-options-collapse-' + thread.id"
          aria-expanded
        >
          <i class="fas fa-chevron-down"></i>
        </button>
      </div>

      <h3 class="title">{{ thread.title }}</h3>
      <div class="text-lg">
        Tópico em '{{ thread.forum.name }}' criado por {{ thread.author.nick }},
        <time
          :datetime="moment(thread.created_at).format()"
        >{{ moment(thread.created_at).fromNow() }}</time>
      </div>
    </div>

    <pagination :data="initialPosts" @pagination-change-page="paginationChangePage"></pagination>

    <post-item v-for="post in posts" :key="post.id" :postId="post.id" :thread="thread"></post-item>
    <!--:real-index="index"-->
    <!--:index="posts.current_page * posts.per_page - posts.per_page + index + 1"-->

    <pagination :data="initialPosts" @pagination-change-page="paginationChangePage"></pagination>

    <div v-if="canReply">
      <div>
        <create-post-editor
          v-if="$gate.allow('write', 'forum', thread.forum)"
          :id="'reply__thread__' + thread.id"
          :thread="thread"
        ></create-post-editor>

        <div v-else>
          <p class="text-center my-4">
            <span class="font-weight-light">Você não tem permissão para escrever neste fórum.</span>
          </p>
        </div>
      </div>
    </div>

    <div v-else>
      <p class="text-center my-4">
        <span class="font-weight-light">Você precisa estar logado para responder.</span>
      </p>
    </div>
  </div>
</template>

<script>
import Pagination from "laravel-vue-pagination";
import VueScrollTo from "vue-scrollto";
import queryString from "query-string";
import PostItem from "./PostItem/Index";
import CreatePostEditor from "@components/forums/Editors/CreatePostEditor/Index";
import * as mutation from "@store/mutation-types";

export default {
  name: "ThreadView",
  components: {
    Pagination,
    PostItem,
    CreatePostEditor
  },
  props: {
    thread: {
      type: Object,
      required: true
    },
    fetchAction: {
      type: String,
      required: true
    },
    initialPosts: {
      type: Object,
      required: true
    },
    canReply: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    posts() {
      return this.$store.getters.posts;
    }
  },
  mounted() {
    this.$store.commit(mutation.UPDATE_POSTS, {
      posts: this.initialPosts.data
    });

    if (window.location.hash && window.location.hash.startsWith("#post-")) {
      VueScrollTo.scrollTo(window.location.hash);
    }

    let optionsCollapseId = "#thread-options-collapse-" + this.thread.id;
    let optionsCollapse = $(optionsCollapseId);
    let optionsCollapseButton = $("[data-target='" + optionsCollapseId + "']");

    optionsCollapse.on("hide.bs.collapse", function() {
      optionsCollapseButton.html('<i class="fas fa-chevron-down"></i>');
    });

    optionsCollapse.on("show.bs.collapse", function() {
      optionsCollapseButton.html('<i class="fas fa-chevron-up"></i>');
    });
  },
  methods: {
    paginationChangePage(page = 1) {
      let query = queryString.parse(location.search);
      query.page = page;
      location.search = queryString.stringify(query);
    }
  }
};
</script>