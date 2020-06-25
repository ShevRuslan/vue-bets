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
            </v-row> </v-container
        >>
    </v-content>
</template>

<script>
import { mapMutations } from 'vuex';
import { mapGetters } from 'vuex';
import API from '../service/api';
import LineMatch from '../components/LineMatch';
export default {
    name: 'Line',
    data() {
        return {
            champs: [],
            currentChamp: null,
            loading: false,
            timer: null
        };
    },
    components: {
        LineMatch
    },
    async created() {
        //получение матчей с линии
        this.getLineMatches();
        //создание таймера на каждую минуту для получение линии
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
            if (!response.error) {
                this.champs = response;
                this.loading = false;
            }
            this.getLineMatches();
            this.timer = setTimeout(this.getMatches, 60000);
        },
        async getLineMatches() {
            const response = await API.getLineChamps();
            if (!response.error) this.setLineChamps(response);
        },
        changeChamp() {
            this.matches = this.champs[this.currentChamp];
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
    color: #474d56;
}
.wrapper-line {
    display: flex;
    justify-content: flex-start;
}
</style>
