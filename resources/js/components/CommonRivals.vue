<template>
    <div class="common-rivals">
        <div class="header text-center">
            <div class="title">
                <h4>Матчи с общими соперниками</h4>
            </div>
        </div>
        <div class="wrapper-content">
            <div class="wrapper-players">
                <div class="first-player text-center mt-10 mb-5 ">
                    <div class="title">
                        <h5>{{ firstPlayer }}</h5>
                    </div>
                    <div class="rating">
                       <RatingStar v-if="this.matches[0][0].rating2" :rating="this.matches[0][0].rating1"></RatingStar>
                    </div>
                </div>
                <div class="second-player text-center mt-10 mb-5">
                    <div class="title">
                        <h5>{{ secondPlayer }}</h5>
                    </div>
                    <div class="rating">
                        <RatingStar v-if="this.matches[0][0].rating2" :rating="this.matches[0][0].rating2"></RatingStar>
                    </div>
                </div>
            </div>
            <div class="wrapper-matches">
                <v-expansion-panels flat>
                    <v-expansion-panel class="expansion" v-for="match in matches" :key="match[0].player2">
                        <v-expansion-panel-header class="expansion-header">
                            <div class="score-match">
                                <ScoreMatch :winFirst="match[0].win1" :winSecond="match[0].win2"> </ScoreMatch>
                            </div>
                            <div class="rivals-name">
                                <div>
                                    {{ match[0].player2 }}
                                </div>
                                <div class="rating">
                                    <RatingStar v-if="match[0].rating2" :rating="match[0].rating2"></RatingStar>
                                </div>
                            </div>
                            <div class="score-match">
                                <ScoreMatch :winFirst="match[1].win1" :winSecond="match[1].win2"> </ScoreMatch>
                            </div>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content class="expansion-content">
                            <div class="rivals-table">
                                <CooperativeMatch
                                    :existName="false"
                                    :existScore="false"
                                    :matches="match[0].mergeGames"
                                    :firstPlayer="match[0].player1"
                                    :secondPlayer="match[0].player2"
                                    class="mt-5"
                                ></CooperativeMatch>
                            </div>
                            <div class="rivals-table">
                                <CooperativeMatch
                                    :existName="false"
                                    :existScore="false"
                                    :matches="match[1].mergeGames"
                                    :firstPlayer="match[1].player1"
                                    :secondPlayer="match[1].player2"
                                    class="mt-5"
                                ></CooperativeMatch>
                            </div>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </div>
        </div>
    </div>
</template>

<script>
import CooperativeMatch from '../components/CooperativeMatch';
import ScoreMatch from '../components/ScoreMatch';
import RatingStar from './RatingStar'; 
export default {
    name: 'CommonRivals',
    props: {
        matches: Array,
        firstPlayer: String,
        secondPlayer: String
    },
    components: {
        CooperativeMatch,
        ScoreMatch,
        RatingStar
    }
};
</script>

<style lang="scss">
.rating {
    font-family: Roboto;
    font-style: normal;
    font-weight: bold;
    font-size: 12px;
    line-height: 14px;
    margin-left: 6px;
}
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
    flex-direction: column;
    width: 100%;
    .first-player,
    .second-player {
        width: 49%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .expansion {
        background-color: transparent !important;
        border-top: 1px solid #c1c5e0;
        border-radius: 0px;
        .expansion-header {
            padding: 0 184px;
            display: flex;
            justify-content: space-around;
            font-weight: 500;
            font-size: 16px;
            text-align: center;
            color: #474d56;
            .v-expansion-panel-header__icon {
                margin-left: 0;
            }
            .score-match {
                max-width: 62px;
                width: 20%;
            }
            .rivals-name {
                width: 60%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }
        .expansion-content {
            .v-expansion-panel-content__wrap {
                display: flex;
                justify-content: space-between;
                background: #f1f3fa;
                .rivals-table {
                    width: 48%;
                }
            }
        }
    }
    .wrapper-players {
        display: flex;
    }
}
</style>
