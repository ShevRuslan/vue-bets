<template>
    <tr>
        <td class="text-left number-info">{{ match.date }}</td>
        <td class="text-left number-info">{{ match.nameMatch }}</td>
        <td class="text-left number-info">+{{ match.plus }}</td>
        <td class="text-left number-info">{{ match.P1 }}</td>
        <td class="text-left number-info">{{ match.P2 }}</td>
        <td class="text-left number-info">{{ match.totalMore }}</td>
        <td class="text-left number-info">{{ match.total }}</td>
        <td class="text-left number-info">{{ match.totalLess }}</td>
        <td class="text-left number-info">{{ match.forFirst }}</td>
        <td class="text-left string-info">{{ match.for }}</td>
        <td class="text-left string-info">{{ match.forSecond }}</td>
        <td class="text-left string-info">{{ match.individualTotalFirstMore}}</td>
        <td class="text-left string-info">{{ match.individualTotalFirst }}</td>
        <td class="text-left string-info">{{ match.individualTotalFirstLess }}</td>
        <td class="text-left string-info">{{ match.individualTotalSecondMore }}</td>
        <td class="text-left string-info">{{ match.individualTotalSecond }}</td>
        <td class="text-left string-info">{{ match.individualTotalSecondLess }}</td>
    </tr>
</template>

<script>
export default {
    props: {
        match: Object,
    },
    data() {
      return {
        
      }
    },
};
</script>

<style scoped>
.number-info {
    font-size: 15px;
    padding: 0 5px;
}
.string-info {
    padding: 0 5px;
    font-size: 12px;
}
.scores-match {
    padding-left: 10px;
    display: flex;
    align-items: center;
}
.scores-match p {
    margin-bottom: 0px;
}
.name-match {
    border-right: 1px solid rgba(0, 0, 0, 0.12);
    padding-right: 5px;
    width: 1%;
    white-space: nowrap;
    font-size: 14px;
}
@media screen and (max-width: 600px) {
    .v-list .v-list-item__action .title {
        font-size: 12px !important;
    }
    .item-list {
        font-size: 12px !important;
    }
    .title-name {
        font-size: 12px;
        white-space: normal;
    }
}
</style>
