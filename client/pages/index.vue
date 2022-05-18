<template>
  <div>
    <div>
      Auth: {{this.$auth.loggedIn}}
    </div>
    <div v-if="this.$auth.loggedIn">
      Hi {{ this.$auth.user.user.username }}
    </div>
    <template v-else>
      <div>Hi Annonymous</div>
    </template>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'IndexPage',
  computed: {
    ...mapGetters(['isAuthenticated', 'loggedInUser'])
  },
  data() {
      return {
        //state post
        validation: []
      }
    },
}
</script>
