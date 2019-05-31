<template>
  <div>
    <div class="d-flex flex-column">
      <div class="row">
        <div class="col-4">
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

        <div class="col-4" v-if="hasGroup(Group.MANAGER)">
          <custom-select
            label="Quem pode responder?"
            v-model="thread.restrict_write"
            :options="restrictOptions"
          />
        </div>

        <div class="col-4" v-if="hasGroup(Group.ADMINISTRATOR)">
          <custom-select
            label="Quem pode ler?"
            v-model="thread.restrict_read"
            :options="[{label: 'Visitantes', value: null}, ...restrictOptions]"
          />
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-4">
          <custom-switch
            label="Fechar tópico"
            v-model="thread.closed"
            v-if="hasGroup(Group.GAME_MASTER)"
          />
        </div>

        <!-- <div class="col-4" v-if="hasGroup(Group.ADMINISTRATOR)">
          <custom-select
            label="Mover para:"
            v-model="thread.restrict_read"
            :options="[{label: 'Visitantes', value: null}, ...restrictOptions]"
          />
        </div>-->
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
    trySaveSettings: function($event) {
      $($event.target).attr("disabled", true);

      axios
        .put(route("forums.api.threads.update", this.thread.id), {
          title: this.thread.title,
          promoted: this.thread.promoted,
          sticky: this.thread.sticky,
          restrict_read: this.thread.restrict_read,
          restrict_write: this.thread.restrict_write,
          closed: this.thread.closed
        })
        .then(response => {
          if (response.status == 202) {
            window.location.href = this.route("forums.thread", [
              this.thread.slug,
              this.thread.id
            ]);
            return;
          }

          $($event.target).attr("disabled", false);
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
