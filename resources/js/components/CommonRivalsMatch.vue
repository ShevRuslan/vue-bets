<template>
    <v-dialog :value="dialog" @input="close" transition="dialog-bottom-transition" class="modal-statics">
        <v-card class="wrapper-dialog">
            <v-btn class="btn-close" dark icon absolute @click="close" color="#000">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-container fluid class="fill-height align-start wrapper-page-search">
                <v-row justify="center" align="center">
                    <v-col class="pa-0">
                        <div class="wrapper-common-rivals mt-10">
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
        commonRivals: Object,
        firstPlayer: String,
        secondPlayer: String,
    },
    components: {
        CommonRivals,
    },
    methods: {
        close() {
            this.$emit('closeInfoDialog', false);
        }
    }
};
</script>

<style></style>
