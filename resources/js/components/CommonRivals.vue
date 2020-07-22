<template>
    <div class="common-rivals">
        <div class="header text-center">
            <div class="title">
                <h4>Матчи с общими соперниками</h4>
            </div>
        </div>
        <div class="wrapper-content">
            <div class="first-player">
                <div class="title mt-10 mb-10">
                    <h5>{{ firstPlayer }}</h5>
                </div>
                <div class="wrapper-matches">
                    <v-expansion-panels flat>
                        <v-expansion-panel class="mb-5 expansion" v-for="match in matches[firstPlayer]" :key="match.player2">
                            <v-expansion-panel-header>{{ match.player2 }}</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <CooperativeMatch
                                    :existName="false"
                                    :matches="match.mergeGames"
                                    :winFirst="match.win1"
                                    :winSecond="match.win2"
                                    class="mt-5"
                                ></CooperativeMatch>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </div>
            </div>
            <div class="second-player">
                <div class="title mt-10 mb-10">
                    <h5>{{ secondPlayer }}</h5>
                </div>
                <div class="wrapper-matches">
                     <v-expansion-panels flat>
                        <v-expansion-panel class="mb-5 expansion" v-for="match in matches[secondPlayer]" :key="match.player2">
                            <v-expansion-panel-header>{{ match.player2 }}</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <CooperativeMatch
                                    :existName="false"
                                    :matches="match.mergeGames"
                                    :winFirst="match.win1"
                                    :winSecond="match.win2"
                                    class="mt-5"
                                ></CooperativeMatch>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CooperativeMatch from '../components/CooperativeMatch';
export default {
    name: 'CommonRivals',
    props: {
        matches: Object,
        firstPlayer: String,
        secondPlayer: String
    },
    components: {
        CooperativeMatch
    }
};
</script>

<style lang="scss">
.header {
    .title {
        width: 100%;
    }
}
.common-rivals {
    width: 100%;
}
.wrapper-content {
    display: flex;
    width: 100%;
    justify-content: space-between;
    .first-player,
    .second-player {
        width: 49%;
    }
    .expansion {
        background-color: transparent !important;
        border: 1px solid #e8ecef;
    }
}
</style>
