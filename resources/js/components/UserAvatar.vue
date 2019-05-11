<template>
    <span :class="computedClasses" :style="computedStyles"></span>
</template>

<script>
    export default {
        name: "UserAvatar",
        props: {
            user: {
                required: true,
                type: Object
            },
            classes: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            styles: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            size: {
                type: String,
                default: 'm'
            },
            defaultImg: {
                type: String,
                default: '/images/no-avatar.jpg'
            }
        },
        computed: {
            computedStyles: function () {
                let size = this.size;

                switch (size) {
                    case 'l':
                        size = '160px';
                        break;
                    case 'm':
                        size = '110px';
                        break;
                    case 's':
                        size = '55px';
                        break;
                }

                let styles = `width: ${size};height: ${size};`;

                styles += this.styles.join(';');

                if (this.user.avatar) {
                    styles += `background-image: url(${this.user.avatar}), url(${this.defaultImg});`
                }

                return styles;
            },
            computedClasses: function () {
                let classes = this.classes;

                classes.push('author-avatar');

                return classes.join(' ');
            }
        }
    }
</script>

<style scoped>

</style>