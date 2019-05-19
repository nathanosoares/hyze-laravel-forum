export default class ForumPolicy {
    static write(user, forum) {
        if (!user) {
            return false;
        }


        for (let current = forum; ; current = current.parent) {
            if (!current) {
                break
            }

            console.log(user.groups, user.groups.filter(g => g.key === current.restrict_write).length > 0);

            if (!current.restrict_write) {
                continue
            }

            if (!user.groups.includes('chatter write forum ' + current.id)) {
                return false
            }
        }

        return true;
    }
}