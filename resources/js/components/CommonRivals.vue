<template>
    <div class="common-rivals">
        <div class="header text-center">
            <div class="title">
                <h4>Матчи с общими соперниками</h4>
            </div>
        </div>
        <div class="wrapper-content">
            <div class="first-player">
                <div class="title mt-10">
                    <h5>{{ firstPlayer }}</h5>
                </div>
                <div class="wrapper-matches">
                    <CooperativeMatch
                        v-for="match in matches[firstPlayer]"
                        :key="match.player2"
                        :nameCard="match.player2"
                        :matches="match.mergeGames"
                        :winFirst="match.win1"
                        :winSecond="match.win2"
                        class="mt-5"
                    ></CooperativeMatch>
                </div>
            </div>
            <div class="second-player">
                <div class="title mt-10">
                    <h5>{{ secondPlayer }}</h5>
                </div>
                <div class="wrapper-matches">
                    <CooperativeMatch
                        v-for="match in matches[secondPlayer]"
                        :key="match.player2"
                        :nameCard="match.player2"
                        :matches="match.mergeGames"
                        :winFirst="match.win1"
                        :winSecond="match.win2"
                        class="mt-5"
                    ></CooperativeMatch>
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
        matches: Array,
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
}
</style>
