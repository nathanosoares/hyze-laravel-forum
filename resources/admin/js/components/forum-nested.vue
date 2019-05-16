<template>
  <div class="ml-4">
    <draggable handle=".move" :list="forums" :group="{ name: 'forums' }">
      <div v-for="el in forums" :key="el.name" class>
        <div class="border py-2 px-3">
          <span class="mr-4 move">
            <i class="fas fa-sort"></i>
          </span>
          <span>{{ el.name }}</span>
          <span class="text-muted mr-2">{{ el.id }} </span>
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