<template>
  <div class="ml-4">
    <draggable handle=".move" :list="forums" :group="{ name: 'forums' }">
      <div v-for="el in forums" :key="el.name" class>
        <div class="border-top py-0 px-3 d-flex align-items-center">
          <span class="mr-4 move">
            <i class="fas fa-sort"></i>
          </span>

          <span>{{ el.name }}</span>

          <div class="ml-auto d-flex align-items-center">
            <span class="text-muted">Forum</span>

            <div class="dropdown ml-auto">
              <button
                class="btn"
                type="button"
                :id="'forumDropdowMenu' + el.id"
                data-toggle="dropdown"
                aria-haspopup="false"
                aria-expanded="false"
              >
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <div
                class="dropdown-menu dropdown-menu-right"
                :aria-labelledby="'forumDropdowMenu' + el.id"
              >
                <a class="dropdown-item" :href="route('admin.forums.edit', el.id)">Editar</a>
              </div>
            </div>
          </div>
        </div>

        <forum-nested :forums="el.children || []"/>
      </div>
    </draggable>
  </div>
</template>
<script>
import draggable from "vuedraggable";

export default {
  props: {
    forums: {
      required: true,
      type: Array
    }
  },
  components: {
    draggable
  },
  name: "forum-nested"
};
</script>