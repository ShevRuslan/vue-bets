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
                clear-icon
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
                background-color="#3C4655"
                class="champ"
            />
        </div>
        <div class="wrapper-slider d-flex flex-row">
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
        </div>
        <div class="wrapper-button-search d-flex flex-row">
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
        </div>
    </div>
</template>

<script>
export default {
    name: "HeaderForm",
    data() {
        return {
            value: 0,
            fruits: 0,
            ticksLabels: ["10", "20", "30", "40"]
        };
    }
};
</script>

<style lang="scss">
.wrapper-header__forms {
    height: 40px;
    width: 100%;
    justify-content: space-between;
}
.wrapper-selects {
    .firstSportsmen {
        .v-input__control {
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
        }
    }
    .secondSportsmen {
        .v-input__control {
            border-radius: 0px;
        }
    }
    .champ {
        .v-input__control {
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
        }
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
