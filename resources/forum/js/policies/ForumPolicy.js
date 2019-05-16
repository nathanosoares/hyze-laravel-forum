export default class ForumPolicy {
    static write(user, forum) {

        for (let current = forum; ; current = current.parent) {
            if (!current) {
                break
            }

            if (!current.restrict_write) {
                continue
            }

            if (!user.all_permissions.includes('chatter write forum ' + current.id)) {
                return false
            }
        }

        return true;
    }
}