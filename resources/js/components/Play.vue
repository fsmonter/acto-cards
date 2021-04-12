<template>
  <div class="p-5 border border-black border-solid">
    <form>
      <label for="username">Username</label>
      <input type="text" name="username" v-model="form.username" />
      <div v-if="errors.username">{{ errors.username[0] }}</div>

      <label for="username">Enter a hand of cards</label>
      <CardInput v-model="form.cards" />
      <div v-if="errors.cards">{{ errors.cards[0] }}</div>

      <button @click.prevent="play">Play!</button>
    </form>
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
    }
  },
  methods: {
    play() {
      axios
        .post('/api/play', {
            username: this.form.username,
            cards: this.form.cards.split(' ')
        })
        .then((response) => {
          console.log('success')
          console.log(response)
        })
        .catch((error) => {
          console.log('error')
          if (error.response.status === 422) {
            this.errors = error.response.data.errors
          }
        })
    },
  },
}
</script>
