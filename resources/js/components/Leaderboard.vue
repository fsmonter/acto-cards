<template>
  <div>
    <ul>
      <li v-for="play in plays" :key="play.id">
        {{ play }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      plays: [],
    }
  },
  mounted() {
    this.fetchPlays()
    this.$root.$on('update-leaderboard', () => {
      this.fetchPlays()
    })
  },
  methods: {
    fetchPlays() {
      axios
        .get('/api/plays')
        .then((response) => {
          this.plays = response.data.plays
        })
        .catch((response) => {
          console.log(response)
        })
    },
  },
}
</script>

<style></style>
