<template>
    <div class="table-bet">
        <v-simple-table class="table">
            <template v-slot:default>
                <thead class="table-header">
                    <template v-if="!isFor">
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">
                                ТБ
                            </th>
                            <th class="text-center">
                                ТМ
                            </th>
                        </tr>
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

                            <template v-if="total.first > 18">
                                <td class="text-center wrapper-color-block wrapper-more-green ">
                                    <div class="more-green">
                                        {{ total.first }}
                                    </div>
                                </td>
                            </template>
                            <template v-else-if="total.first < 18 && total.first > 12">
                                <td class="text-center wrapper-color-block wrapper-less-green ">
                                    <div class="less-green">
                                        {{ total.first }}
                                    </div>
                                </td>
                            </template>
                            <template v-else>
                                <td class="text-center wrapper-color-block wrapper-not-green ">
                                    <div class="not-green">
                                        {{ total.first }}
                                    </div>
                                </td>
                            </template>

                            <template v-if="total.second > 18">
                                <td class="text-center wrapper-color-block wrapper-more-green ">
                                    <div class="more-green">
                                        {{ total.second }}
                                    </div>
                                </td>
                            </template>
                            <template v-else-if="total.second < 18 && total.second > 12">
                                <td class="text-center wrapper-color-block wrapper-less-green ">
                                    <div class="less-green">
                                        {{ total.second }}
                                    </div>
                                </td>
                            </template>
                            <template v-else>
                                <td class="text-center wrapper-color-block wrapper-not-green ">
                                    <div class="not-green">
                                        {{ total.second }}
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
                            <template v-if="total.number > 18">
                                <td class="text-center wrapper-color-block wrapper-more-green ">
                                    <div class="more-green">
                                        {{ total.number }}
                                    </div>
                                </td>
                            </template>
                            <template v-else-if="total.number < 18 && total.number > 12">
                                <td class="text-center wrapper-color-block wrapper-less-green ">
                                    <div class="less-green">
                                        {{ total.number }}
                                    </div>
                                </td>
                            </template>
                            <template v-else>
                                <td class="text-center wrapper-color-block wrapper-not-green ">
                                    <div class="not-green">
                                        {{ total.number }}
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
        headerFor: String
    },
    created() {
        if (this.isFor) {
            this.items.sort((a, b) => {
                if (parseFloat(a.value) > parseFloat(b.value)) return 1;
                else return -1;
            });
        }
    }
};
</script>

<style></style>
