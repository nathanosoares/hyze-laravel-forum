<template>
    <div class="post-author post-author-gm d-flex flex-column align-items-center">
        <user-avatar :user="author" :classes="['mb-3']" size="l"/>
        <h5 class="title m-0">{{ author.name }}</h5>
        <user-twitter-anchor :user="author" :classes="['text-decoration-none', 'text-muted']" />
    </div>
</template>

<script>
    import UserAvatar from '@components/UserAvatar'
    import UserTwitterAnchor from '@components/UserTwitterAnchor'

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
    }
</script>

<style scoped lang="scss">
    .author-avatar {
        @extend .author-avatar;
        width: 160px;
        height: 160px;
        border: 5px solid rgba(255, 255, 255, 0.1);
    }
</style>