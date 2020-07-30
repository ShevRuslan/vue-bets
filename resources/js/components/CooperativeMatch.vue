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
                    xmlns:dc="http://purl.org/dc/elements/1.1/"
                    xmlns:cc="http://creativecommons.org/ns#"
                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                    xmlns:svg="http://www.w3.org/2000/svg"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                    xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                    width="34"
                    height="15"
                    viewBox="0 0 15 15"
                    fill="none"
                    version="1.1"
                    id="svg42"
                    sodipodi:docname="Group 24.svg"
                    inkscape:version="0.92.4 (5da689c313, 2019-01-14)"
                    @click="searchRivalsMatches"
                >
                    <metadata id="metadata48">
                        <rdf:RDF>
                            <cc:Work rdf:about="">
                                <dc:format>image/svg+xml</dc:format>
                                <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
                                <dc:title />
                            </cc:Work>
                        </rdf:RDF>
                    </metadata>
                    <defs id="defs46" />
                    <sodipodi:namedview
                        pagecolor="#ffffff"
                        bordercolor="#666666"
                        borderopacity="1"
                        objecttolerance="10"
                        gridtolerance="10"
                        guidetolerance="10"
                        inkscape:pageopacity="0"
                        inkscape:pageshadow="2"
                        inkscape:window-width="1920"
                        inkscape:window-height="1027"
                        id="namedview44"
                        showgrid="false"
                        inkscape:zoom="15.733333"
                        inkscape:cx="7.5"
                        inkscape:cy="7.5"
                        inkscape:window-x="-8"
                        inkscape:window-y="-8"
                        inkscape:window-maximized="1"
                        inkscape:current-layer="svg42"
                    />
                    <rect width="24" height="15" rx="3" ry="3" id="rect38" x="0" y="0" style="fill:#f0ac0e" />
                    <path
                        d="m 11.848393,3.4250573 c 0.11974,-0.36852 0.6411,-0.36852 0.76084,0 l 0.7646,2.35319 c 0.05355,0.16481 0.20713,0.2764 0.38042,0.2764 h 2.47426 c 0.3875,0 0.5486,0.49584 0.2352,0.7236 l -2.00179,1.45436 c -0.1402,0.10185 -0.19886,0.2824 -0.14531,0.44721 l 0.7646,2.3532207 c 0.1197,0.3685 -0.3021,0.6749 -0.61554,0.4472 l -2.00175,-1.45437 c -0.14019,-0.1018507 -0.33003,-0.1018507 -0.47022,0 l -2.0017496,1.45437 c -0.3134898,0.2277 -0.7352798,-0.0787 -0.6155398,-0.4472 L 10.141013,8.6798173 c 0.05355,-0.16481 -0.0051,-0.34536 -0.1453096,-0.44721 l -2.0017398,-1.45436 c -0.31349,-0.22776 -0.15238,-0.7236 0.23511,-0.7236 h 2.4742994 c 0.17329,0 0.32687,-0.11159 0.38042,-0.2764 z"
                        id="path40"
                        inkscape:connector-curvature="0"
                        style="fill:#474d56"
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
            // const data = {
            //     player1: this.firstPlayer,
            //     player2: this.secondPlayer,
            //     countMatches: this.getCountRivalsMatch,
            //     coopChamps: true,
            //     line: false
            // };
            // const rivalsMatches = await API.getRivalsMatch(data);
            // this.setRivalsMatch(rivalsMatches);
            this.$emit('closeInfoDialogRivals', true);
        }
    }
};
</script>

<style scoped lang="scss">
.header {
    display: flex;
    .wrapper-info-coop {
        display: flex;
    }
    .wrapper_get-rivals {
        display: flex;
        align-items: center;
    }
}
.wrapper_get-rivals {
    svg {
        cursor: pointer;
    }
}
</style>
