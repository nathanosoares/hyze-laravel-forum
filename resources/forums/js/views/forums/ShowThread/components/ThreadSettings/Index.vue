<template>
  <div>
    <div class="d-flex flex-column">
      <div class="d-flex justify-content-between align-items-center">
        <div class="flex-fill px-2">
          <custom-switch
            label="Promover para home"
            v-model="thread.promoted"
            v-if="hasGroup(Group.GAME_MASTER)"
          />
          <custom-switch
            label="Fixar no topo"
            v-model="thread.sticky"
            v-if="hasGroup(Group.MANAGER)"
          />
        </div>

        <div class="flex-fill px-2" v-if="hasGroup(Group.MANAGER)">
          <custom-select
            label="Quem pode responder?"
            v-model="thread.restrict_write"
            :options="restrictOptions"
          />
        </div>

        <div class="flex-fill px-2" v-if="hasGroup(Group.ADMINISTRATOR)">
          <custom-select
            label="Quem pode ler?"
            v-model="thread.restrict_read"
            :options="[{label: 'Visitantes', value: null}, ...restrictOptions]"
          />
        </div>
      </div>

      <button class="btn btn-primary rounded-pill ml-auto mt-4" @click="trySaveSettings">Salvar</button>
    </div>
  </div>
</template>

<script>
import CustomSwitch from "./components/CustomSwitch";
import CustomSelect from "./components/CustomSelect";

import { Group, hasGroup } from "@base/forums/js/GroupManager";

export default {
  name: "ThreadSettings",
  components: {
    CustomSwitch,
    CustomSelect
  },
  props: {
    thread: {
      type: Object,
      required: true
    }
  },
  data: function() {
    return {
      restrictOptions: [],
      Group
    };
  },
  methods: {
    hasGroup: function(group) {
      return hasGroup(this.$user, group);
    },
    trySaveSettings: function() {
      axios
        .put(route("forums.api.threads.update", this.thread.id), {
          title: this.thread.title,
          promoted: this.thread.promoted,
          sticky: this.thread.sticky,
          restrict_read: this.thread.restrict_read,
          restrict_write: this.thread.restrict_write
        })
        .then(response => {
          console.log(response);
        });
    }
  },
  mounted() {
    Object.keys(Group).forEach(item => {
      this.restrictOptions.push({
        label: Group[item].display_name,
        value: item
      });
    });
  }
};
</script>
