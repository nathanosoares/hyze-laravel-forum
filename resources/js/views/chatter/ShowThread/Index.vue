<template>
    <div class="thread-wrapper">
        <div class="thread-header">
            <h3 class="title">{{ thread.title }}</h3>
            <p>
                Tópico em '<span class="font-weight-normal">{{ thread.forum.name }}</span>'
                criado por <span class="font-weight-normal">{{ thread.author.name }}</span>,
                <time :datetime="moment(thread.created_at).format()">{{ moment(thread.created_at).fromNow() }}</time>
            </p>
        </div>

        <pagination :data="initialPosts" @pagination-change-page="paginationChangePage"></pagination>

        <post-item v-for="post in posts"
                   :key="post.id"
                   :postId="post.id"
                   :thread="thread"></post-item>
        <!--:real-index="index"-->
        <!--:index="posts.current_page * posts.per_page - posts.per_page + index + 1"-->


        <pagination :data="initialPosts" @pagination-change-page="paginationChangePage"></pagination>

        <div v-if="canReply">
            <div>
                <create-post-editor v-if="$gate.allow('write', 'forum', thread.forum)"
                                    :id="'reply__thread__' + thread.id" :thread="thread"></create-post-editor>

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
    import Pagination from 'laravel-vue-pagination'
    import VueScrollTo from 'vue-scrollto'
    import queryString from 'query-string'
    import PostItem from './PostItem/Index'
    import CreatePostEditor from '@components/chatter/Editors/CreatePostEditor/Index'
    import * as mutation from '@store/mutation-types'

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
                return this.$store.getters.posts
            }
        },
        mounted() {
            this.$store.commit(mutation.UPDATE_POSTS, {posts: this.initialPosts.data})

            if (window.location.hash && window.location.hash.startsWith('#post-')) {
                VueScrollTo.scrollTo(window.location.hash);
            }
        },
        methods: {
            paginationChangePage(page = 1) {
                let query = queryString.parse(location.search)
                query.page = page
                location.search = queryString.stringify(query)
            },
        }
    }
</script>

<style scoped>

</style>