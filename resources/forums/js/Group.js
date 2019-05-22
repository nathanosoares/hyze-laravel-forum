import { isNull } from "util";

function Group(display_name, color, priority) {
    this.display_name = display_name;
    this.color = color;
    this.priority = priority;
}

Group.prototype.isHigher = function (group) {
    if (isNull(group)) {
        return true;
    }

    return this.priority > group.priority;
}

Group.prototype.isSameOrHigher = function (group) {
    if (isNull(group)) {
        return true;
    }

    return this.priority >= group.priority;
}

const GAME_MASTER = new Group('Hyze', '#FFAA00', 11);

const MANAGER = new Group('Gerente', '#AA0000', 10);

const ADMINISTRATOR = new Group('Administrador', '#FF5555', 9);

const MODERATOR = new Group('Moderador', '#55FF55', 8);

const HELPER = new Group('Ajudante', '#FFFF55', 7);

const YOUTUBER = new Group('Youtuber', '#FF5555', 6);

const MVP = new Group('MVP', '#55FFFF', 5);

const VIP_PLUS = new Group('VIP+', '#FFAA00', 4);

const VIP = new Group('VIP', '#FFAA00', 3);

const BUILDER = new Group('Construtor', '#55FF55', 2);

const DEFAULT = new Group('Membro', '#AAAAAA', 1);

export default {
    GAME_MASTER,
    MANAGER,
    ADMINISTRATOR,
    MODERATOR,
    HELPER,
    YOUTUBER,
    MVP,
    VIP_PLUS,
    VIP,
    BUILDER,
    DEFAULT
};