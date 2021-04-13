require('./bootstrap')

import Vue from 'vue'
import Game from '@/components/Game'
import Leaderboard from '@/components/Leaderboard'

const vm = new Vue({
  el: '#app',
  components: { Game, Leaderboard },
})
