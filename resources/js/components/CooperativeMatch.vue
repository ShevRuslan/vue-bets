<template>
    <div>
        <v-card
            class="pa-10 card-match"
        >
            <v-card-text>
                <p class="display-1 text--primary name-player">
                    {{  firstPlayer  }} - {{secondPlayer}}
                </p>
                <p>
                  {{winFirst}} - {{winSecond}}
                </p>
                <Match 
                  v-for="match in matches"
                  :key="match.id"
                  :match="match"
                  />
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import Match from './Match';
  export default {
    props: {
      firstPlayer: String,
      secondPlayer: String,
      winFirst: Number,
      winSecond: Number,
      matches: Array,
    },
    data () {
      return {
        
      }
    },
    components: {
      Match,
    }
  }
</script>

<style scoped>
 @media screen and (max-width:600px) {
       .name-player {
         font-size: 24px !important;
       }
       .card-match {
         padding: 10px !important;
       }
    }
</style>
