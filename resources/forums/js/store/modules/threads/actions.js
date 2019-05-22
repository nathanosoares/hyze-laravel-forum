import * as mutations from '@store/mutation-types'
import * as actions from '@store/action-types'

export default {
    [actions.UPDATE_POST]({commit}, {post, body}) {
        return new Promise((resolve, reject) => {
            window.axios.put(route('forums.api.posts.update', post.id), {
                body
            }).then(response => {
                commit(mutations.UPDATE_POST, {post: response.data})
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
    [actions.FETCH_REPLIES]({commit}, {post, page}) {
        return new Promise((resolve, reject) => {
            window.axios.get(route('forums.api.posts.replies', post.id), {
                params: {
                    page
                }
            }).then(response => {
                commit(mutations.ADD_POST_REPLIES, {post, replies: response.data.data})
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
    [actions.CREATE_POST]({commit}, {parent, thread, body}) {
        return new Promise((resolve, reject) => {
            let endpoint;

            if (parent) {
                endpoint = route('forums.api.posts.replies.store', parent.id)
            } else if (thread) {
                endpoint = route('forums.api.threads.posts.store', thread.id)
            }

            if (endpoint) {
                window.axios.post(endpoint, {
                    body
                }).then(response => {
                    if (parent) {
                        commit(mutations.ADD_POST_REPLIES, {post: parent, replies: [response.data]})
                    } else {
                        commit(mutations.ADD_POST, {post: response.data})
                    }
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            }
        })
    },
    [actions.DELETE_POST]({commit}, {post}) {
        return new Promise((resolve, reject) => {
            window.axios.delete(route('forums.api.posts.destroy', post.id), {maxRedirects: 0})
                .then(response => {
                    commit(mutations.REMOVE_POST, {post})
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
        })
    }
}