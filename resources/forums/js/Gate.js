import PostPolicy from './policies/PostPolicy';
import ForumPolicy from './policies/ForumPolicy';

export default class Gate {

    constructor(user) {
        this.user = user;

        this.policies = {
            post: PostPolicy,
            forum: ForumPolicy
        };
    }

    before() {
        return this.user && this.user.is_super_admin;
    }

    allow(actions, type, model = null, strict = false) {

        if (!Array.isArray(actions)) {
            actions = [actions];
        }

        let allow = false;


        for (let i = 0; i < actions.length; i++) {
            let action = actions[i];

            if (!this.policies.hasOwnProperty(type) || !this.policies[type].hasOwnProperty(action)) {
                allow = allow || false;
            } else {
                allow = allow || this.before() || (this.user && this.policies[type][action](this.user, model));
            }

            if (strict && !allow) {
                return false;
            }
        }

        return allow;
    }

    deny(action, type, model = null) {
        return !this.allow(action, type, model);
    }
}