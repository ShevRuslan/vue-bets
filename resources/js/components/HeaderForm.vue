<template>
    <div class="d-flex flex-row wrapper-header__forms">
        <div class="wrapper-selects d-flex flex-row">
            <v-autocomplete
                v-model.trim="player1"
                :items="entries1"
                :loading="isLoading1"
                :search-input.sync="searchSportsmen1"
                item-text="name"
                return-object
                required
                outlined
                label="Первый игрок"
                hide-no-data
                dense
                background-color="#3C4655"
                append-icon=""
                class="firstSportsmen"
            />
            <v-autocomplete
                v-model.trim="player2"
                :items="entries2"
                :loading="isLoading2"
                :search-input.sync="searchSportsmen2"
                item-text="name"
                return-object
                required
                outlined
                label="Второй игрок"
                hide-no-data
                dense
                background-color="#3C4655"
                append-icon=""
                class="secondSportsmen"
            />
            <v-autocomplete
                v-model.trim="tourney"
                :items="champs"
                item-text="name"
                return-object
                required
                outlined
                label="Лига"
                hide-no-data
                dense
                append-icon=""
                background-color="#3C4655"
                class="champ"
            />
            <v-autocomplete
                v-model.trim="count"
                :items="numbers"
                item-text="name"
                return-object
                required
                outlined
                label="Кол-во"
                hide-no-data
                dense
                background-color="#3C4655"
                class="count"
            />
            <v-btn
                :loading="loadingMatches"
                color="#3688FC"
                dense
                @click="search"
                height="100%"
                width="104"
                class="text-capitalize button-search"
            >
                Поиск
            </v-btn>
            <v-snackbar v-model="snackbar" color="success" left bottom>
                Матчи успешно получены!
                <v-btn text @click="snackbar = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-snackbar>
        </div>
        <!-- <div class="wrapper-slider d-flex flex-row">
            <v-slider
                v-model="count"
                label="Количество"
                hide-details
                track-color="#F1F3FA"
                thumb-size="4"
                class="wrapper-slider__slider"
                color="#3688FC"
                ticks="always"
                tick-size="12"
                :tick-labels="ticksLabels"
                :min="10"
                :max="40"
                step="10"
            ></v-slider>
        </div> -->
        <!-- <div class="wrapper-button-search d-flex flex-row">
            <v-btn
                :loading="loadingMatches"
                color="#3688FC"
                dense
                @click="search"
                height="100%"
                width="104"
                class="text-capitalize"
            >
                Поиск
            </v-btn>
            <v-snackbar v-model="snackbar" color="success" left bottom>
                Матчи успешно получены!
                <v-btn text @click="snackbar = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-snackbar>
        </div> -->
    </div>
</template>

<script>
import API from "../service/api";
import { mapActions } from 'vuex';
export default {
    name: "HeaderForm",
    data() {
        return {
            value: 0,
            fruits: 0,
            ticksLabels: ["10", "20", "30", "40"],
            tourney: null,
            isLoading1: false,
            isLoading2: false,
            player1: null,
            player2: null,
            entries1: [],
            entries2: [],
            searchSportsmen1: null,
            searchSportsmen2: null,
            matches: [],
            champs: [],
            count: "",
            lastUpdateDate: "",
            loadingMatches: false,
            snackbar: false,
            historySearch: [],
            numbers: [
                0,
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16,
                17,
                18,
                19,
                20,
                21,
                22,
                23,
                24,
                25,
                26,
                27,
                28,
                29,
                30,
                31,
                32,
                33,
                34,
                35,
                36,
                37,
                38,
                39,
                40,
                41,
                42,
                43,
                44,
                45,
                46,
                47,
                48,
                49,
                50,
                51,
                52,
                53,
                54,
                55,
                56,
                57,
                58,
                59,
                60,
                61,
                62,
                63,
                64,
                65,
                66,
                67,
                68,
                69,
                70,
                71,
                72,
                73,
                74,
                75,
                76,
                77,
                78,
                79,
                80,
                81,
                82,
                83,
                84,
                85,
                86,
                87,
                88,
                89,
                90,
                91,
                92,
                93,
                94,
                95,
                96,
                97,
                98,
                99,
                100
            ]
        };
    },
    async created() {
        this.champs = await API.getAllChamps();
        const saveHistorySearch = JSON.parse(
            localStorage.getItem("historySearch")
        );
        if (saveHistorySearch) this.historySearch = saveHistorySearch;
    },
    methods: {
        ...mapActions(['setResponse']),
        search: async function() {
            const data = {
                player1: this.player1.name,
                player2: this.player2.name,
                champName: this.tourney,
                countMatches: this.count
            };
            this.searchByData(data);
        },
        searchByData: async function(data) {

            this.loadingMatches = true;
            const matches = await API.searchBySportsmen(data);
            console.log()
            this.setResponse(matches);

            const current = this.historySearch.filter(match => {
                return (
                    match.player1 == data.player1 &&
                    match.player2 == data.player2 &&
                    match.champName == data.champName
                );
            });

            if (current.length == 0) {
                this.historySearch.push(data);
                let saveHistorySearch = JSON.parse(
                    localStorage.getItem("historySearch")
                );
                if (!saveHistorySearch) saveHistorySearch = [];
                saveHistorySearch.push(data);
                localStorage.setItem(
                    "historySearch",
                    JSON.stringify(saveHistorySearch)
                );
            }
            this.snackbar = true;
            this.loadingMatches = false;
        },
        getLastUpdateDate: async function() {
            this.loadingLastDate = true;
            this.lastUpdateDate = await API.getLastUpdateDate();
            this.dialog = true;
            this.loadingLastDate = false;
        },
        changeHistorySearch: function() {
            this.historySearch = [];
        },
        showAsideMenu: function(data) {
            this.drawer = data ? data : !this.drawer;
        }
    },
    watch: {
        async searchSportsmen1(val) {
            if (this.isLoading1) return;
            this.isLoading1 = true;
            this.entries1 = await API.searchSportsmen({
                name: this.searchSportsmen1
            });
            this.isLoading1 = false;
        },
        async searchSportsmen2(val) {
            if (this.isLoading2) return;
            this.isLoading2 = true;
            this.entries2 = await API.searchSportsmen({
                name: this.searchSportsmen2
            });
            this.isLoading2 = false;
        }
    }
};
</script>

<style lang="scss">
.wrapper-header__forms {
    height: 40px;
    width: 100%;
    justify-content: center;
}
.wrapper-selects {
    fieldset {
        border: none;
    }
    .firstSportsmen {
        .v-input__control {
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
        }
    }
    .secondSportsmen {
        fieldset {
            border-right: 1px solid #f1f3fa;
            border-left: 1px solid #f1f3fa;
        }
        .v-input__control {
            border-radius: 0px;
        }
    }
    .champ {
        fieldset {
            border-right: 1px solid #f1f3fa;
        }
        border: none;
        .v-input__control {
            border-radius: 0px;
        }
    }
    .count {
        width: 120px;
        .v-input__control {
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
        }
    }
    .button-search {
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
    }
}
.wrapper-slider {
    width: 40%;
    padding-left: 16px;
    .wrapper-slider__slider {
        justify-content: center;
        align-items: center;
        .v-slider__track-container {
            height: 4px !important;
        }
        .v-slider__tick {
            background-color: #f1f3fa;
            border-radius: 100%;
        }
        .v-slider__tick--filled {
            background-color: #3688fc;
        }
        .v-slider__tick-label {
            font-size: 12px;
            transform: translateX(0%) !important;
            top: 14px;
        }
    }
}
.wrapper-button-search {
    padding-left: 16px;
}
</style>
