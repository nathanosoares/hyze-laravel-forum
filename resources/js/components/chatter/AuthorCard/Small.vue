<template>
    <div class="post-author post-author-gm d-flex flex-column align-items-center">
        <span class="author-avatar mb-1"></span>
    </div>
</template>

<script>
    export default {
        name: "AuthorCard",
        props: {
            author: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped lang="scss">
    .author-avatar {
        @extend .author-avatar;
        width: 70px;
        height: 70px;
        border: 3px solid rgba(255, 255, 255, 0.1);
    }
</style>