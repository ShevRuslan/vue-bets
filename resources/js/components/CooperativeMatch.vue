<template>
    <div>
        <div class="header">
            <div class="header__title" v-if="nameCard == ''">
                {{ getNameCard(firstPlayer) }}-{{ getNameCard(secondPlayer) }}
            </div>
            <div class="header__title" v-if="nameCard != ''">{{ nameCard }}</div>
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
import CoopMatch from './СoopMatch';
export default {
    name: 'CooperativeMatch',
    components: {
        CoopMatch
    },
    props: {
        firstPlayer: String,
        secondPlayer: String,
        winFirst: Number,
        winSecond: Number,
        matches: Array,
        nameCard: {
            type: String,
            default: ''
        }
    },
    data() {
        return {};
    },
    methods: {
        getNameCard(name) {
            const arrayName = name.split(' ');
            return `${arrayName[1]} ${arrayName[0][0]}.`;
        }
    }
};
</script>

<style scoped lang="scss"></style>
