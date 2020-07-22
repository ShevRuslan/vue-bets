<template>
    <div>
        <div class="header">
            <template v-if="existName">
                <div class="header__title" v-if="nameCard == ''">
                    {{ getNameCard(firstPlayer) }}-{{ getNameCard(secondPlayer) }}
                </div>
                <div class="header__title" v-if="nameCard != ''">{{ nameCard }}</div>
            </template>
            <div class="header__score">
                <template v-if="winFirst < winSecond">
                    <v-chip color="#FF0000" text-color="white" class="score__chip">
                        {{ winFirst }}
                    </v-chip>
                    :
                    <v-chip color="#33CC33" text-color="white" class="score__chip">
                        {{ winSecond }}
                    </v-chip>
                </template>
                <template v-else-if="winFirst > winSecond">
                    <v-chip color="#33CC33" text-color="white" class="score__chip">
                        {{ winFirst }}
                    </v-chip>
                    :
                    <v-chip color="#FF0000" text-color="white" class="score__chip">
                        {{ winSecond }}
                    </v-chip>
                </template>
                <template v-else>
                    <v-chip color="#33CC33" text-color="white" class="score__chip">
                        {{ winFirst }}
                    </v-chip>
                    :
                    <v-chip color="#33CC33" text-color="white" class="score__chip">
                        {{ winSecond }}
                    </v-chip>
                </template>
            </div>
            <div class="wrapper_get-rivals ml-2" v-if="showGetRivalsMatch">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    version="1.1"
                    id="Capa_1"
                    x="0px"
                    y="0px"
                    viewBox="0 0 512 512"
                    style="enable-background:new 0 0 512 512;"
                    xml:space="preserve"
                    width="15px"
                    height="15px"
                    @click="searchRivalsMatches"
                >
                    <g transform="matrix(1 0 0 1 0 0)">
                        <path
                            style="fill:#F3BB3B"
                            d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256  C511.835,114.683,397.317,0.165,256,0z"
                            data-original="#4CAF50"
                            class=""
                            data-old_color="#4CAF50"
                        />
                        <path
                            style="fill:#4B5159"
                            d="M426.091,199.211C424.614,194.898,420.559,192,416,192H305.877l-39.979-99.968  c-2.78-5.473-9.471-7.656-14.943-4.875c-2.101,1.067-3.808,2.775-4.875,4.875L206.123,192H96  c-5.891-0.005-10.671,4.766-10.676,10.657c-0.003,3.299,1.521,6.414,4.127,8.436l90.389,70.4l-30.123,110.379  c-1.544,5.685,1.813,11.546,7.498,13.09c2.974,0.808,6.152,0.29,8.716-1.42L256,343.467l90.091,60.053  c4.901,3.269,11.524,1.947,14.793-2.954c1.71-2.564,2.228-5.742,1.42-8.716L332.16,281.387l90.389-70.4  C426.101,208.205,427.519,203.49,426.091,199.211z"
                            data-original="#FAFAFA"
                            class="active-path"
                            data-old_color="#FAFAFA"
                        />
                    </g>
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
export default {
    name: 'CooperativeMatch',
    components: {
        CoopMatch
    },
    props: {
        showGetRivalsMatch: {
            type: Boolean,
            default: false,
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
                line: false,
            };
            const rivalsMatches = await API.getRivalsMatch(data);
            this.setRivalsMatch(rivalsMatches);
            this.$emit('closeInfoDialogRivals', true);
        }
    }
};
</script>

<style scoped lang="scss">
.wrapper_get-rivals {
    svg {
        cursor: pointer;
    }
}
</style>
