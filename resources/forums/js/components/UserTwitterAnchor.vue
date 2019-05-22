<template>
    <a role="link" rel="noreferrer" :href="'https://twitter.com/' + user.nick" target='_blank'
       :class="computedClasses">
        <slot>@{{ user.nick }}</slot>
    </a>
</template>

<script>
    export default {
        name: "UserTwitterAnchor",
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
            }
        },
        computed: {
            computedClasses: function () {
                let classes = this.classes;
                return classes.join(' ');
            }
        }
    }
</script>

<style scoped>

</style>