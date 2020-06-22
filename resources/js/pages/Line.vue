<template>
    <v-content>
        <v-container class="fill-height pa-6 pl-0 align-start" max-width="600px">
            <v-row justify="center" align="center">
                <v-col class="pa-0">
                    <div class="current-champ pb-12 ">
                        {{ getCurrentLineChamps }}
                    </div>
                    <div class="wrapper-line">
                        <LineMatch :matches="currentChampMatches" />
                    </div>
                </v-col>
            </v-row>
        </v-container>>
    </v-content>
</template>

<script>
import { mapMutations } from 'vuex';
import { mapGetters } from 'vuex';
import API from '../service/api';
import LineMatch from '../components/LineMatch';
export default {
    name: 'Line',
    data: function() {
        return {
            champs: [],
            currentId: null,
            expanded: [],
            matches: [],
            currentChamp: null,
            singleExpand: false,
            headers: [
                {
                    text: 'Дата',
                    value: 'date'
                },
                {
                    text: 'Матч',
                    value: 'nameMatch'
                },
                {
                    text: '+',
                    value: 'plus'
                },
                {
                    text: 'П1',
                    value: 'P1'
                },
                {
                    text: 'П2',
                    value: 'P2'
                },
                {
                    text: 'Б',
                    value: 'totalMore'
                },
                {
                    text: 'Тотал',
                    value: 'total'
                },
                {
                    text: 'М',
                    value: 'totalLess'
                },
                {
                    text: '1',
                    value: 'forFirst'
                },
                {
                    text: 'Фора',
                    value: 'for'
                },
                {
                    text: '2',
                    value: 'forSecond'
                },
                {
                    text: 'Б',
                    value: 'individualTotalFirstMore'
                },
                {
                    text: 'ИТ1',
                    value: 'individualTotalFirst'
                },
                {
                    text: 'М',
                    value: 'individualTotalFirstLess'
                },
                {
                    text: 'Б',
                    value: 'individualTotalSecondMore'
                },
                {
                    text: 'ИТ2',
                    value: 'individualTotalSecond'
                },
                {
                    text: 'М',
                    value: 'individualTotalSecondLess'
                }
            ],
            loading: false,
            timer: null,
        };
    },
    components: {
        LineMatch
    },
    async created() {
        this.getLineMatches();
        this.getMatches();
    },
    beforeDestroy() {
        clearTimeout(this.timer);
    },
    computed: {
        ...mapGetters(['getCurrentLineChamps']),
        currentChampMatches() {
            return this.champs[this.getCurrentLineChamps];
        }
    },
    methods: {
        ...mapMutations(['setLineChamps']),
        getMatches: async function() {
            this.loading = true;
            const response = await API.getLineMatches();
            this.champs = response;
            this.loading = false;
            this.getLineMatches();
            this.timer = setTimeout(this.getMatches, 60000);
        },
        async getLineMatches() {
            const response = await API.getLineChamps();
            this.setLineChamps(response);
        },
        changeChamp() {
            this.matches = this.champs[this.currentChamp];
        },
        async loadStatics({ item, value }) {
            if (value) {
                this.loading = true;
                this.currentId = item.id;
                const players = item.nameMatch.split('-');
                const firstPlayer = players[0].trim();
                const secondPlayer = players[1].trim();
                const response = await API.searchBySportsmen({
                    player1: firstPlayer,
                    player2: secondPlayer,
                    champName: this.currentChamp,
                    countMatches: 10
                });

                const objectMatch = {
                    matches: response,
                    id: item.id
                };

                const exMatch = this.exsistMatch(item.id);

                console.log(exMatch);
                if (exMatch != null) {
                    this.fetchMatches[exMatch] = objectMatch;
                } else {
                    this.fetchMatches.push(objectMatch);
                }
                this.loading = false;
            }
        },
        exsistMatch(id) {
            let exsist = null;
            this.fetchMatches.forEach((element, index) => {
                if (element.id == id) exsist = index;
            });
            return exsist;
        }
    }
};
</script>

<style lang="scss">
.current-champ {
    font-weight: bold;
    font-size: 18px;
    line-height: 21px;
    /* identical to box height */

    color: #474d56;
}
.wrapper-line {
    display: flex;
    justify-content: flex-start;
}
</style>
