import * as types from '@store/mutation-types'

export default {
    [types.UPDATE_POSTS](state, {posts}) {
        state.posts = posts

        state.posts.map(post => {
            if (!post.replies) {
                post.replies = []
            }
        })
    },
    [types.UPDATE_POST](state, {post}) {
        let target = null

        if (post.parent) {
            let index = state.posts.findIndex(targetPost => targetPost.id === post.parent.id)

            if (index > -1) {
                let parent = state.posts[index]
                index = parent.replies.findIndex(targetPost => targetPost.id === post.id)
                if (index > -1) {
                    target = parent.replies[index]
                }
            }

        } else {
            let index = state.posts.findIndex(targetPost => targetPost.id === post.id)
            if (index > -1) {
                target = state.posts[index]
            }
        }


        if (target) {
            target.body = post.body
            target.body_parsed = post.body_parsed
        }
    },
    [types.ADD_POST](state, {post}) {
        if (!post.replies) {
            post.replies = []
        }

        state.posts.push(post)
    },
    [types.ADD_POST_REPLIES](state, {post, replies}) {

        let index = state.posts.findIndex(targetPost => targetPost.id === post.id)

        if (index > -1) {
            let post = state.posts[index]
            replies = [...replies, ...post.replies]

            post.replies = Array.from(new Set(replies.map(reply => reply.id)))
                .map(id => replies.find(reply => reply.id === id))

            Vue.set(state.posts, index, post)
        }
    },
    [types.REMOVE_POST](state, {post}) {
        if (post.parent) {
            let parentIndex = state.posts.findIndex(targetPost => targetPost.id === post.parent.id)

            if (parentIndex > -1) {
                let parent = state.posts[parentIndex]

                let postIndex = parent.replies.findIndex(targetPost => targetPost.id === post.id)

                if (postIndex > -1) {
                    Vue.delete(parent.replies, postIndex)
                    Vue.set(state.posts, parentIndex, parent)
                }
            }
        } else {
            let index = state.posts.findIndex(targetPost => targetPost.id === post.id)

            if (index > -1) {
                Vue.delete(state.posts, index)
            }
        }
    }
}