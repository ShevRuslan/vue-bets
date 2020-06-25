<template>
    <div class="table-bet">
        <v-simple-table class="table">
            <template v-slot:default>
                <thead class="table-header">
                    <template v-if="!isFor">
                        <slot></slot>
                    </template>
                    <template v-else>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">
                                {{ headerFor }}
                            </th>
                        </tr>
                    </template>
                </thead>
                <tbody class="table-content">
                    <template v-if="!isFor">
                        <tr v-for="total in items" :key="total.value">
                            <td class="text-center wrapper-left-number">
                                <div class="left-number">
                                    {{ total.value }}
                                </div>
                            </td>

                            <template>
                                <td class="text-center wrapper-color-block wrapper-not-green ">
                                    <div class="not-green">
                                        {{ total.first }} / {{countGames}}
                                    </div>
                                </td>
                            </template>


                            <template>
                                <td class="text-center wrapper-color-block wrapper-not-green ">
                                    <div class="not-green">
                                        {{ total.second }} / {{countGames}}
                                    </div>
                                </td>
                            </template>
                        </tr>
                    </template>
                    <template v-else>
                        <tr v-for="total in items" :key="total.value">
                            <td class="text-center wrapper-left-number">
                                <div class="left-number">
                                    {{ total.value }}
                                </div>
                            </td>
                            <template>
                                <td class="text-center wrapper-color-block wrapper-not-green ">
                                    <div class="not-green">
                                       {{ total.number }} / {{countGames}}
                                    </div>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </template>
        </v-simple-table>
    </div>
</template>

<script>
export default {
    props: {
        items: Array,
        isFor: Boolean,
        headerFor: String,
        countGames: Number,
        reverseArray: Boolean
    },
    created() {
        if (this.isFor && this.reverseArray) {
            this.items.sort((a, b) => {
                if (parseFloat(a.value) < parseFloat(b.value)) return 1;
                else return -1;
            });
        } else {
             this.items.sort((a, b) => {
                if (parseFloat(a.value) > parseFloat(b.value)) return 1;
                else return -1;
            });
        }
    }
};
</script>

<style>
</style>
