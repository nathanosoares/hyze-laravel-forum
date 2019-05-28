import { Group } from './../GroupManager';

export default class ForumPolicy {
    static write(user, forum) {
        if (!user) {
            return false;
        }

        for (let current = forum; ; current = current.parent) {
            if (!current) {
                break
            }

            if (!current.restrict_write) {
                continue
            }

            if (!Group[user.highest_group.key].isSameOrHigher(Group[current.restrict_write])) {
                return false;
            }
        }

        return true;
    }
}