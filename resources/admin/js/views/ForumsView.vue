<template>
  <div class="d-flex flex-column">
    <div class="d-flex align-items-center mb-4">
      <div class="ml-auto">
        <a class="btn btn-primary btn-sm" :href="route('admin.categories.create')">
          <i class="fas fa-plus"></i>
          Categoria
        </a>

        <a class="btn btn-primary btn-sm" :href="route('admin.forums.create')">
          <i class="fas fa-plus"></i>
          Forum
        </a>
      </div>
    </div>

    <div>
      <draggable handle=".move" :list="sorted" :group="{ name: 'categories' }">
        <transition-group>
          <div v-for="category in sorted" :key="category.id">
            <div class="border py-2 px-3 d-flex align-items-center">
              <span class="mr-3 move">
                <i class="fas fa-sort"></i>
              </span>

              <span>{{ category.name }}</span>

              <div class="ml-auto d-flex align-items-center">
                <span class="text-muted">Categoria</span>

                <div class="dropdown ml-3">
                  <button
                    class="btn"
                    type="button"
                    :id="'categoryDropdowMenu' + category.id"
                    data-toggle="dropdown"
                    aria-haspopup="false"
                    aria-expanded="false"
                  >
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <div
                    class="dropdown-menu dropdown-menu-right"
                    :aria-labelledby="'categoryDropdowMenu' + category.id"
                  >
                    <a
                      class="dropdown-item"
                      :href="route('admin.categories.edit', category.id)"
                    >Editar</a>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <forum-nested :forums="category.forums"/>
            </div>
          </div>
        </transition-group>
      </draggable>
    </div>

    <div class="ml-auto mt-4">
      <button class="btn btn-success" @click="trySaveForums">Salvar</button>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import forumNested from "../components/forum-nested";

export default {
  name: "ForumsView",
  components: {
    draggable,
    forumNested
  },
  props: {
    categories: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      sorted: []
    };
  },
  mounted() {
    this.categories.forEach((category, index) => {
      this.sorted.push({
        id: category.id,
        name: category.name,
        type: "category",
        forums: this.getForums(category.forums) || []
      });
    });
  },
  methods: {
    getForums: function(children, forums = []) {
      children.forEach((forum, index) => {
        forums.push({
          id: forum.id,
          name: forum.name,
          type: "forum",
          children: this.getForums(forum.children || [], [])
        });
      });

      return forums;
    },
    trySaveForums: function() {
      axios
        .post(route("admin.tree.sort"), {
          categories: this.sorted
        })
        .then(function(response) {
          alert("Sucesso!");
          console.log(response);
        })
        .catch(function(error) {
          alert("Erro!");
          console.log(error);
        });
    }
  }
};
</script>

<style lang="scss">
.move {
  -ms-touch-action: none;
  touch-action: none;
  cursor: move;
}
</style>
