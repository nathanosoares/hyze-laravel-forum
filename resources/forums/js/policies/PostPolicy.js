import { Group } from './../GroupManager';

export default class PostPolicy {
    // static create(user) {
    //     return user.role === 'editor';
    // }

    static destroy(user, post) {
        return Group[user.highest_group.key].isSameOrHigher(Group.MANAGER);
    }

    static edit(user, post) {
        return user.id == post.user_id || Group[user.highest_group.key].isSameOrHigher(Group.ADMINISTRATOR);
    }

    static reply(user, post) {
        return user.email_verified_at && !post.closed
    }
}