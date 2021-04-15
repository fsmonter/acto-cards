<template>
  <div class="p-5 bg-gray-100 border">
    <form class="flex flex-col items-center justify-center px-24">
      <text-input class="w-full" label="Username" v-model="form.username" :errors="errors.username" name="username" />
      <text-input class="w-full" label="Enter your hand of cards (use a space for each card)" v-model="form.cards" :errors="errors.cards" name="cards" />
      <button class="h-8 px-4 font-bold text-white bg-green-500 rounded focus:border-green-800" @click.prevent="play" @disabled="form.cards.length <= 0">Play!</button>
    </form>
    <div v-if="results">
      <div>
        {{ results.challengeCards }}
      </div>
      <h2 v-if="results.is_winner">You won!</h2>
      <h2>Score</h2>
      <p>Player {{ results.score }}</p>
      <p>Challenge {{ results.challengeScore }}</p>
    </div>
  </div>
</template>

<script>
import TextInput from '@/components/TextInput'
export default {
  components: {
    TextInput
  },
  data() {
    return {
      form: {
        username: '',
        cards: ''
      },
      errors: [],
      results: null
    }
  },
  methods: {
    play() {
      axios
        .post('/api/games', {
          username: this.form.username,
          cards: this.form.cards.split(' ')
        })
        .then(response => {
          this.results = response.data.results
          this.$root.$emit('update-leaderboard')
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors
          }
        })
    }
  }
}
</script>
