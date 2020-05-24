<template>
    <div>
        <v-card
            class="pa-10"
        >
            <v-card-text>
                <p class="display-1 text--primary">
                    {{  name  }}
                </p>
                <p>Последние 10 матчей:</p>
                <v-list>
                  <v-list-group
                    v-for="match in matches"
                    :key="match.id"
                    
                  >
                    <template v-slot:activator>
                      <v-list-item-content>
                        <v-list-item-title v-text="match.nameGame"></v-list-item-title>
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
                                <v-list-item-title>{{ match.scores }}</v-list-item-title>
                              </v-list-item-content>
                            </v-list-item>
                            <v-divider :inset="inset"></v-divider>
                            <v-list-item >
                              <v-list-item-action>
                               <p class="title ma-0">Турнир:</p>
                              </v-list-item-action>
                              <v-list-item-content>
                                <v-list-item-title>{{ match.champName }}</v-list-item-title>
                              </v-list-item-content>
                            </v-list-item>
                            <v-divider :inset="inset"></v-divider>
                            <v-list-item >
                              <v-list-item-action>
                               <p class="title ma-0">Дата:</p>
                              </v-list-item-action>
                              <v-list-item-content>
                                <v-list-item-title>{{ match.date }}</v-list-item-title>
                              </v-list-item-content>
                            </v-list-item>
                            <v-divider :inset="inset"></v-divider>
                              <v-list-item>
                                  <v-list-item-action>
                                <p class="title ma-0">Стадия:</p>
                                </v-list-item-action>
                                <v-list-item-content>
                                  <v-list-item-title>{{ match.add_info }}</v-list-item-title>
                                </v-list-item-content>
                              </v-list-item>
                            <v-divider :inset="inset"></v-divider>
                          </v-list>  
                      </v-col>
                  </v-row>
                  </v-list-group>
            </v-list>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
  export default {
    props: {
      name: String,
      matches: Array,
    },
    data () {
      return {
        
      }
    },
  }
</script>

<style scoped>
</style>
