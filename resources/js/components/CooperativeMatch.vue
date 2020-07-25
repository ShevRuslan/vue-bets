<template>
    <div>
        <div class="header">
            <div class="wrapper-info-coop">
                <template v-if="existName">
                    <div class="header__title" v-if="nameCard == ''">
                        {{ getNameCard(firstPlayer) }}-{{ getNameCard(secondPlayer) }}
                    </div>
                    <div class="header__title" v-if="nameCard != ''">{{ nameCard }}</div>
                </template>
                <ScoreMatch v-if="existScore" :winFirst="winFirst" :winSecond="winSecond"> </ScoreMatch>
            </div>
            <div class="wrapper_get-rivals ml-2" v-if="showGetRivalsMatch">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="15"
                    height="15"
                    viewBox="0 0 15 15"
                    fill="none"
                    @click="searchRivalsMatches"
                >
                    <rect width="15" height="15" rx="3" fill="#F0AC0E" />
                    <path
                        d="M7.11958 3.17082C7.23932 2.8023 7.76068 2.8023 7.88042 3.17082L8.64502 5.52401C8.69857 5.68882 8.85215 5.80041 9.02544 5.80041H11.4997C11.8872 5.80041 12.0483 6.29625 11.7349 6.52401L9.73311 7.97837C9.59291 8.08022 9.53425 8.26077 9.5878 8.42558L10.3524 10.7788C10.4721 11.1473 10.0503 11.4537 9.73686 11.226L7.73511 9.77163C7.59492 9.66978 7.40508 9.66978 7.26489 9.77163L5.26314 11.226C4.94965 11.4537 4.52786 11.1473 4.6476 10.7788L5.4122 8.42558C5.46575 8.26077 5.40709 8.08022 5.26689 7.97837L3.26515 6.52401C2.95166 6.29625 3.11277 5.80041 3.50026 5.80041H5.97456C6.14785 5.80041 6.30143 5.68882 6.35498 5.52401L7.11958 3.17082Z"
                        fill="#474D56"
                    />
                </svg>
            </div>
        </div>
        <div class="content">
            <v-simple-table class="elevation-0">
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-right name-match element-header">
                                Дата
                            </th>
                            <th class="text-left element-header scores-match">
                                Счёт
                            </th>
                            <th class="text-left element-header">Δ1</th>
                            <th class="text-left element-header">Очки</th>
                            <th class="text-left element-header">Δ2</th>
                            <th class="text-left element-header">Тотал</th>
                            <th class="text-left element-header">Турнир</th>
                        </tr>
                    </thead>
                    <tbody>
                        <CoopMatch v-for="match in matches" :key="match.id" :match="match" :player="firstPlayer" />
                    </tbody>
                </template>
            </v-simple-table>
        </div>
    </div>
</template>

<script>
import API from '../service/api';
import { mapActions } from 'vuex';
import { mapGetters } from 'vuex';
import CoopMatch from './СoopMatch';
import ScoreMatch from './ScoreMatch';
export default {
    name: 'CooperativeMatch',
    components: {
        CoopMatch,
        ScoreMatch
    },
    props: {
        showGetRivalsMatch: {
            type: Boolean,
            default: false
        },
        firstPlayer: String,
        secondPlayer: String,
        winFirst: Number,
        winSecond: Number,
        matches: Array,
        existName: {
            type: Boolean,
            default: true
        },
        existScore: {
            type: Boolean,
            default: true
        },
        nameCard: {
            type: String,
            default: ''
        }
    },
    data() {
        return {};
    },
    computed: {
        ...mapGetters(['getCountLineMatches', 'getCountRivalsMatch'])
    },
    methods: {
        ...mapActions(['setRivalsMatch']),
        getNameCard(name) {
            const arrayName = name.split(' ');
            return `${arrayName[1]} ${arrayName[0][0]}.`;
        },
        async searchRivalsMatches() {
            const data = {
                player1: this.firstPlayer,
                player2: this.secondPlayer,
                countMatches: this.getCountRivalsMatch,
                coopChamps: true,
                line: false
            };
            const rivalsMatches = await API.getRivalsMatch(data);
            this.setRivalsMatch(rivalsMatches);
            this.$emit('closeInfoDialogRivals', true);
        }
    }
};
</script>

<style scoped lang="scss">
.header {
    display: flex;
    justify-content: space-between;
    .wrapper-info-coop {
        display: flex;
    }
}
.wrapper_get-rivals {
    svg {
        cursor: pointer;
    }
}
</style>
