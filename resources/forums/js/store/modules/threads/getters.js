export default {
    posts: state => state.posts,
    postById: state => id => state.posts.find(post => post.id === id),
}