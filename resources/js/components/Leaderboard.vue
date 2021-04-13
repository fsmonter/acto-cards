<template>
  <div>
    <table class="min-w-full divide-y divide-gray-200" v-if="games.length > 0">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
            Username
          </th>
          <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
            Games
          </th>
          <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
            Wins
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(game, index) in games" :key="game.id">
          <td
            class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"
            :class="{ 'bg-yellow-100 text-white': index === 0, 'bg-gray-100 text-white': index === 1, 'bg-red-50 text-white': index === 2 }"
          >
            {{ game.username }}
          </td>
          <td
            class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"
            :class="{ 'bg-yellow-100 text-white': index === 0, 'bg-gray-100 text-white': index === 1, 'bg-red-50 text-white': index === 2 }"
          >
            {{ game.games }}
          </td>
          <td
            class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"
            :class="{ 'bg-yellow-100 text-white': index === 0, 'bg-gray-100 text-white': index === 1, 'bg-red-50 text-white': index === 2 }"
          >
            {{ game.wins }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      games: []
    }
  },
  mounted() {
    this.fetchGames()
    this.$root.$on('update-leaderboard', () => {
      this.fetchGames()
    })
  },
  methods: {
    fetchGames() {
      axios
        .get('/api/games')
        .then(response => {
          this.games = response.data.games
        })
        .catch(response => {
          console.log(response)
        })
    }
  }
}
</script>
