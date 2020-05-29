<template>
        <v-list>
          <v-list-group>

            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title class="title-name" >{{match.nameGame}}</v-list-item-title>
              </v-list-item-content>
            </template>

            <v-row>
              <v-col cols="12" width="100%">   
                  <v-list>
                    <v-list-item >
                      <v-list-item-action>
                        <p class="title ma-0">Счёт:</p>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title class="item-list">{{ match.scores }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-list-item >
                      <v-list-item-action>
                        <p class="title ma-0">Турнир:</p>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title class="item-list">{{ match.champName }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-list-item >
                      <v-list-item-action>
                        <p class="title ma-0">Дата:</p>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title class="item-list">{{ match.date }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                      <v-list-item>
                          <v-list-item-action>
                        <p class="title ma-0">Стадия:</p>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title class="item-list">{{ match.add_info }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    <v-divider></v-divider>
                    <v-list-item>
                          <v-list-item-action>
                        <p class="title ma-0">Тотал:</p>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title class="item-list">{{ this.total }}</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                    <v-divider></v-divider>
                      <v-list-item>
                          <v-list-item-action>
                        <p class="title ma-0">Тотал 1:</p>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title class="item-list">{{ this.totalFirst }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-divider></v-divider>
                      <v-list-item>
                          <v-list-item-action>
                        <p class="title ma-0">Тотал 2:</p>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title class="item-list">{{ this.totalSecond }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-divider></v-divider>
                      <v-list-item>
                          <v-list-item-action>
                        <p class="title ma-0">Фор 2:</p>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title class="item-list">{{ this.forFirst }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-divider></v-divider>
                      <v-list-item>
                          <v-list-item-action>
                        <p class="title ma-0">Фор 2:</p>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title class="item-list">{{ this.forSecond }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-divider></v-divider>
                  </v-list>  
              </v-col>
          </v-row>
          </v-list-group>
    </v-list>
</template>

<script>
  export default {
    props: {
      name: String,
      match: Object,
    },
    data () {
      return {
        regex:/[\(\,](?<before>\d+)[\:](?<after>\d+)/gm,
        total: 0,
        totalFirst: 0,
        totalSecond: 0,
        forFirst: 0,
        forSecond: 0,
      }
    },
    created() {
        let matcher = this.match.scores.matchAll(this.regex);

        for(let match of matcher) {
            let { before, after } = match.groups;
            this.total += parseInt(before) + parseInt(after);
            this.totalFirst += parseInt(before);
            this.totalSecond += parseInt(after);
        }
        this.forFirst = this.totalFirst - this.totalSecond;
        this.forSecond = this.totalSecond - this.totalFirst;
    }
  }
</script>

<style scoped>
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
