<template>
  <div class="d-flex flex-column col-lg-10 mx-lg-auto">
    <!-- <login-modal v-if="mounted" :cancel-url="route('forums.forum', [forum.slug, forum.id])"></login-modal> -->

    <div class="form-group">
      <h5 class>Título</h5>
      <input type="text" class="form-control form-control-lg" v-model="title">
    </div>

    <create-thread-editor v-model="body"></create-thread-editor>

    <button
      class="btn btn-primary rounded-pill ml-auto mt-4"
      :disabled="!canSubmit"
      @click="tryCreateThread"
    >Postar thread</button>
  </div>
</template>

<script>
import CreateThreadEditor from "@components/forums/Editors/CreateThreadEditor/Index";

export default {
  name: "CreateThreadView",
  props: {
    forum: {
      type: Object,
      required: true
    },
    template: {
      type: Object
    }
  },
  components: {
    CreateThreadEditor
  },
  data() {
    return {
      title: null,
      canSubmit: false,
      body: null,
      mounted: false
    };
  },
  mounted() {
    this.mounted = true;
    this.body = this.template ? this.template.main_post.body : ""
  },
  watch: {
    title: function() {
      this.updateCanSubmit();
    },
    body: function() {
      this.updateCanSubmit();
    }
  },
  methods: {
    updateCanSubmit() {
      if (
        !(
          this.title != null &&
          this.title.length >= 3 &&
          this.title.length <= 60
        )
      ) {
        this.canSubmit = false;
        return;
      }

      let tmp = document.createElement("div");
      tmp.innerHTML = this.body;

      let rawText = (tmp.textContent || tmp.innerText || "").replace(/ /g, "");

      this.canSubmit = rawText.length >= 10;
    },
    tryCreateThread: function() {
      this.canSubmit = false;

      window.axios
        .post(route("forums.api.threads.store", this.forum.id), {
          title: this.title,
          body: this.body
        })
        .then(response => {
          if (response.status === 201) {
            window.location = route("forums.thread", [
              response.data.slug,
              response.data.id
            ]);
          }
        });
    },
    showImagePrompt(command) {
      const src = prompt("Digite a URL da sua imagem aqui");

      if (src !== null) {
        command({ src });
      }
    }
  }
};
</script>