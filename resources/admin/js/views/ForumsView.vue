<template>
  <div class="d-flex flex-column">
    <button class="btn btn-success ml-auto mb-4" @click="trySaveForums">Salvar</button>

    <div>
      <draggable handle=".move" :list="sorted" :group="{ name: 'categories' }">
        <transition-group>
          <div v-for="category in sorted" :key="category.id">
            <div class="border py-2 px-3">
              <span class="mr-3 move">
                <i class="fas fa-sort"></i>
              </span>
              <span>{{ category.name }}</span>
            </div>

            <div>
              <forum-nested :forums="category.forums"/>
            </div>
          </div>
        </transition-group>
      </draggable>
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
        .post(route("admin.forums.sort"), {
          categories: this.sorted
        })
        .then(function(response) {
          console.log("Sucesso!");
          console.log(response);
        })
        .catch(function(error) {
          console.log("Erro!");
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
