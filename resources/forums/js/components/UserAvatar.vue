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
    overlay: {
      type: Object
    },
    classes: {
      type: Array,
      default: function() {
        return [];
      }
    },
    styles: {
      type: Array,
      default: function() {
        return [];
      }
    },
    size: {
      type: String,
      default: "m"
    },
    defaultImg: {
      type: String,
      default: "/images/no-avatar.png"
    }
  },
  computed: {
    computedStyles: function() {
      let size = this.size;

      switch (size) {
        case "l":
          size = "160px";
          break;
        case "m":
          size = "110px";
          break;
        case "s":
          size = "55px";
          break;
      }

      let styles = `width: ${size};height: ${size};`;

      styles += this.styles.join(";");

      if (this.user.nick) {
        let pixels = size.replace(/\D/g, "");

        styles += `background-image: url(https://cravatar.eu/helmavatar/${
          this.user.nick
        }/${pixels}), url(${this.defaultImg});`;

        if (this.overlay && this.overlay.nick != this.user.nick) {
          // console.log(this.overlay);
        }
      }

      return styles;
    },
    computedClasses: function() {
      let classes = this.classes;

      classes.push("author-avatar");

      return classes.join(" ");
    }
  }
};
</script>