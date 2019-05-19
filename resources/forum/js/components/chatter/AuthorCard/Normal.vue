<template>
  <div class="post-author post-author-gm d-flex flex-column align-items-center">
    <user-avatar :user="author" :classes="['mb-3', 'rounded']" size="120px"/>
    <span
      class="rounded-pill py-2 px-3 text-white"
      :style="`background-color: ${this.author.highest_group.value.color};`"
    >{{ author.nick }}</span>
  </div>
</template>

<script>
import UserAvatar from "@components/UserAvatar";
import UserTwitterAnchor from "@components/UserTwitterAnchor";

export default {
  name: "AuthorCard",
  components: {
    UserAvatar,
    UserTwitterAnchor
  },
  props: {
    author: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped lang="scss">
.author-avatar {
  width: 160px;
  height: 160px;
  /*border: 5px solid rgba(255, 255, 255, 0.1);*/
}
</style>