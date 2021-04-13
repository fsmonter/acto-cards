<template>
  <div class="p-5 border border-black border-solid">
    <form>
      <label for="username">Username</label>
      <input type="text" name="username" v-model="form.username" />
      <div v-if="errors.username">{{ errors.username[0] }}</div>

      <label for="username"
        >Enter a hand of cards (use a space for each card)</label
      >
      <input type="text" v-model="form.cards" />
      <div v-if="errors.cards">{{ errors.cards[0] }}</div>

      <button @click.prevent="play">Play!</button>
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
import CardInput from '@/components/CardInput'
export default {
  components: {
    CardInput,
  },
  data() {
    return {
      form: {
        username: '',
        cards: '',
      },
      errors: [],
      results: null,
    }
  },
  methods: {
    play() {
      axios
        .post('/api/play', {
          username: this.form.username,
          cards: this.form.cards.split(' '),
        })
        .then((response) => {
          this.results = response.data.results
          this.$root.$emit('update-leaderboard')
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors
          }
        })
    },
  },
}
</script>
