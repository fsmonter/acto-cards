require('./bootstrap')

import Vue from 'vue'
import Play from '@/components/Play'
import Leaderboard from '@/components/Leaderboard'

const vm = new Vue({
  el: '#app',
  components: { Play, Leaderboard },
})
