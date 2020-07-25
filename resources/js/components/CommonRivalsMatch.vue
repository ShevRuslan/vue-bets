<template>
    <v-dialog
        :value="dialog"
        @input="close"
        transition="dialog-bottom-transition"
        max-width="840px"
        content-class="dialog-rivals"
    >
        <v-card class="wrapper-dialog">
            <v-btn class="btn-close" dark icon absolute @click="close" color="#000">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-container fluid class="fill-height align-start wrapper-page-search pl-0 pr-0">
                <v-row justify="center" align="center">
                    <v-col class="pa-0">
                        <div class="wrapper-common-rivals">
                            <CommonRivals
                                :matches="commonRivals"
                                :firstPlayer="firstPlayer"
                                :secondPlayer="secondPlayer"
                            ></CommonRivals>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
import CommonRivals from '../components/CommonRivals';
export default {
    name: 'CommonRivalsMatch',
    props: {
        dialog: Boolean,
        commonRivals: Array,
        firstPlayer: String,
        secondPlayer: String
    },
    components: {
        CommonRivals
    },
    methods: {
        close() {
            this.$emit('closeInfoDialog', false);
        }
    }
};
</script>

<style>
.dialog-rivals {
    max-height: 560px !important;
}
</style>
