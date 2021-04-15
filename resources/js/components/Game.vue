<template>
  <div class="px-32 py-10 bg-white border rounded">
    <form class="flex flex-col items-center justify-center">
      <text-input class="w-full" label="Username" v-model="form.username" :errors="errors.username" name="username" />
      <text-input class="w-full" label="Enter your hand of cards (use a space for each card)" v-model="form.cards" :errors="errors.cards" name="cards" />
      <button class="h-8 px-4 font-bold text-white rounded bg-green-acto focus:border-green-800 hover:bg-green-700" @click.prevent="play" @disabled="form.cards.length <= 0">Play!</button>
    </form>
    <div class="flex flex-wrap items-center mt-5 shadow" v-if="results">
      <div class="w-full p-5 bg-white border-t border-l border-r rounded-t">
        <h2 v-text="results.is_winner ? 'Winner!' : 'Try again'" class="text-2xl text-center"></h2>
        <p class="text-2xl font-extrabold text-center">{{ results.challengeCards.join(' ') }}</p>
      </div>
      <div class="w-1/2 p-5 border rounded-bl">
        <p class="text-2xl font-extrabold text-center">{{ results.score }}</p>
        <p class="text-center">Player</p>
      </div>
      <div class="w-1/2 p-5 border rounded-br">
        <p class="text-2xl font-extrabold text-center">{{ results.challengeScore }}</p>
        <p class="text-center">
          Challenge
        </p>
      </div>
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
          cards: this.form.cards.trim().split(' ')
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
