export default class PostPolicy {
    // static create(user) {
    //     return user.role === 'editor';
    // }

    static destroy(user, post) {
        return user.id === post.author.id || user.all_permissions.includes('chatter delete any post');
    }

    static edit(user, post) {
        return user.id === post.author.id || user.all_permissions.includes('chatter edit any post');
    }

    static reply(user, post) {
        return !post.closed
    }
}