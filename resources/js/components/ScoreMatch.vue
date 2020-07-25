<template>
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
</template>

<script>
export default {
    name: 'ScoreMatch',
    props: {
        winFirst: Number,
        winSecond: Number
    }
};
</script>

<style lang="scss">
.header__score {
    display: flex;
    justify-content: center;
    align-items: center;
    .score__chip {
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 3px;
        width: 24px;
        height: 15px;
        font-size: 12px !important;
        line-height: 14px !important;
        padding: 0px;
    }
    .score__chip:first-child {
        margin-right: 5px;
    }
    .score__chip:last-child {
        margin-left: 5px;
    }
}
</style>
