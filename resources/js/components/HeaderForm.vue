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
                solo
                label="Первый игрок"
                hide-no-data
                dense
                background-color="#3C4655"
                append-icon=""
                class="firstSportsmen"
                clearable
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
                solo
                background-color="#3C4655"
                append-icon=""
                class="secondSportsmen"
                clearable
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
                solo
                append-icon=""
                background-color="#3C4655"
                class="champ"
                clearable
            />
            <v-autocomplete
                v-model.trim="count"
                :items="numbers"
                item-text="name"
                return-object
                required
                outlined
                solo
                label="Кол-во"
                hide-no-data
                dense
                background-color="#3C4655"
                class="count"
                clearable
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
        </div>
    </div>
</template>

<script>
import API from '../service/api';
import { mapActions } from 'vuex';
import { mapMutations } from 'vuex';
import { mapGetters } from 'vuex';
export default {
    name: 'HeaderForm',
    data() {
        return {
            tourney: undefined,
            isLoading1: false,
            isLoading2: false,
            player1: null,
            player2: null,
            entries1: [],
            entries2: [],
            searchSportsmen1: null,
            searchSportsmen2: null,
            champs: [],
            count: 10,
            lastUpdateDate: '',
            loadingMatches: false,
            numbers: [10, 15, 20, 25, 30, 35, 40, 45, 50]
        };
    },
    async created() {
        let response = await API.getAllChamps();
        this.champs = Object.values(response);
        const saveHistorySearch = JSON.parse(localStorage.getItem('historySearch'));
        if (saveHistorySearch) {
            this.setHistory(saveHistorySearch);
        }
    },
    methods: {
        ...mapMutations(['setHistory']),
        search: async function() {
            const data = {
                player1: this.player1.name,
                player2: this.player2.name,
                champName: this.tourney,
                countMatches: this.count,
                coopChamps: true
            };
            this.$emit('search', data);
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
    .v-label {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 16px;
    }
    .v-text-field--outlined.v-input--has-state fieldset,
    .v-text-field--outlined.v-input--is-focused fieldset {
        border: none;
    }
    fieldset {
        border: none;
        font-size: 12px;
    }
    .firstSportsmen {
        .v-input__control {
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
        }
    }
    .secondSportsmen {
        fieldset {
            border-right: 1px solid #f1f3fa !important;
            border-left: 1px solid #f1f3fa !important;
        }
        .v-input__control {
            border-radius: 0px;
        }
    }
    .champ {
        fieldset {
            border-right: 1px solid #f1f3fa !important;
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
