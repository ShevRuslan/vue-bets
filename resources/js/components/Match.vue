<template>
        <tr>
          <td class="text-left element-match">{{ this.total }}</td>
          <td class="text-left element-match">{{ this.totalFirst }}</td>
          <td class="text-left element-match">{{ this.totalSecond }}</td>
          <td class="text-left element-match">{{ this.forFirst }}</td>
          <td class="text-left element-match">{{ this.forSecond }}</td>
          <td v-if="!cooperativeMatch" class="text-left name-match element-match">{{ this.nameMatch }}</td>
          <td class="text-left element-match">{{ this.scores }}</td>
          <td class="text-left element-match">{{ match.champName }}</td>
          <td class="text-left element-match">{{ this.info }}</td>
          <td class="text-left element-match">{{ this.date }}</td>
        </tr>
</template>

<script>
  export default {
    props: {
      name: String,
      match: Object,
      player: String,
      cooperativeMatch: Boolean,
    },
    data () {
      return {
        regex:/[\(\,](?<before>\d+)[\:](?<after>\d+)/gm,
        regexScore: /^\s*(?<masterBefore>\d+)\:(?<masterAfter>\d+)\s*/gm,
        total: 0,
        totalFirst: 0,
        totalSecond: 0,
        forFirst: 0,
        forSecond: 0,
        info: '',
        scores: '',
        date: '',
        reverse: false,
        nameMatch: ''
      }
    },
    created() {

        if(this.player != undefined) {
          const arrayPlayers = this.match.nameGame.split('-');
          let first = arrayPlayers[0].trim();
          let second = arrayPlayers[1].trim();
          if(first != this.player) {
            this.reverse = true;
            this.nameMatch = `${first}`
          }
          else {
            this.nameMatch = `${second}`;
          }
        }

        //Дата
        const dateInMS = Date.parse(this.match.date);
        const date = new Date(dateInMS);
        const day = date.getDate();
        const month = date.getMonth() + 1;
        this.date = `${day}.${month}`
        //Дата

        let matcher = this.match.scores.matchAll(this.regex);

        for(let match of matcher) {
            let { before, after } = match.groups;
            this.total += parseInt(before) + parseInt(after);
            if(this.reverse) {
              this.totalFirst += parseInt(after);
              this.totalSecond += parseInt(before);
            }
            else {
              this.totalFirst += parseInt(before);
              this.totalSecond += parseInt(after);
            }
        }

        let scores = this.match.scores.matchAll(this.regexScore);

        for(let score of scores) {
          let {masterBefore, masterAfter} = score.groups;
          if(this.reverse)  this.scores = `${masterAfter}:${masterBefore}`;
          else  this.scores = `${masterBefore}:${masterAfter}`;
        }
        
        this.forFirst = this.totalFirst - this.totalSecond;
        this.forSecond = this.totalSecond - this.totalFirst;

        if(this.match.add_info != null) {
           if(this.match.add_info.trim() != '') {

            try {
              let arrayInfo = JSON.parse(this.match.add_info)
              arrayInfo.forEach(info => {
                console.log(Object.values(info)[0]);
                this.info += Object.values(info)[0];
                this.info += " .";
              })
            }
            catch (e) {
              this.info = this.match.add_info;
            }
        }
        }
    }
  }
</script>

<style scoped>
  .element-match {
    padding: 0px;
    font-size: 12px;
  }
    @media screen and (max-width:600px) {
        .v-list .v-list-item__action  .title {
          font-size: 12px !important;
        }
        .item-list {
          font-size: 12px !important;
        }
        .title-name {
          font-size: 12px;
          white-space: normal;
        }
    }
</style>
