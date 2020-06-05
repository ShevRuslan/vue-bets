<template>
    <tr>
        <td v-if="!cooperativeMatch" class="text-right name-match string-info">
            {{ this.nameMatch }}
        </td>
        <td class="text-left number-info">
            <template v-if="scoreFirst > scoreSecond">
                <div class="scores-match font-weight-bold ">
                    <p style="color:#4CAF50">
                        {{ this.scoreFirst }}:{{ this.scoreSecond }}
                    </p>
                </div>
            </template>
            <template v-else>
                <div class="scores-match font-weight-bold">
                    <p style="color:#D32F2F">
                        {{ this.scoreFirst }}:{{ this.scoreSecond }}
                    </p>
                </div>
            </template>
        </td>
        <td class="text-left number-info">{{ this.forFirst }}</td>
        <td class="text-left number-info">{{ this.totalFirst }}</td>
        <td class="text-left number-info">{{ this.forSecond }}</td>
        <td class="text-left number-info">{{ this.totalSecond }}</td>
        <td class="text-left number-info">{{ this.total }}</td>
        <td class="text-left number-info">{{ this.date }}</td>
        <td class="text-left string-info">{{ match.champName }}</td>
        <td class="text-left string-info">{{ this.info }}</td>
    </tr>
</template>

<script>
export default {
    props: {
        name: String,
        match: Object,
        player: String,
        cooperativeMatch: Boolean
    },
    data() {
        return {
            regex: /[\(\,](?<before>\d+)[\:](?<after>\d+)/gm,
            regexScore: /^\s*(?<masterBefore>\d+)\:(?<masterAfter>\d+)\s*/gm,
            total: 0,
            totalFirst: 0,
            totalSecond: 0,
            forFirst: 0,
            forSecond: 0,
            info: "",
            date: "",
            reverse: false,
            nameMatch: "",
            scoreFirst: "",
            scoreSecond: "",
        };
    },
    watch: {
        player: {
            handler() {
                this.createMatch();
            },
            immediate: true,
        },
        match: {
            handler() {
                this.createMatch();
            },
            immediate: true,
            deep: true,
        }
    },
    methods: {
        createMatch() {
            this.clearInfo();
            
            if (this.player != undefined) {
                const arrayPlayers = this.match.nameGame.split("-");
                let first = arrayPlayers[0].trim();
                let second = arrayPlayers[1].trim();
                if (first !== this.player.trim()) {
                    this.reverse = true;
                    this.nameMatch = `${first}`;
                } else {
                    this.nameMatch = `${second}`;
                }
            }

            const dateInMS = Date.parse(this.match.date);
            const date = new Date(dateInMS);
            const day = date.getDate();
            const month = date.getMonth() + 1;
            this.date = `${day}.${month}`;

            let matcher = this.match.scores.matchAll(this.regex);

            for (let match of matcher) {
                let { before, after } = match.groups;
                this.total += parseInt(before) + parseInt(after);
                if (this.reverse) {
                    this.totalFirst += parseInt(after);
                    this.totalSecond += parseInt(before);
                } else {
                    this.totalFirst += parseInt(before);
                    this.totalSecond += parseInt(after);
                }
            }

            let scores = this.match.scores.matchAll(this.regexScore);

            for (let score of scores) {
                let { masterBefore, masterAfter } = score.groups;
                if (this.reverse) {
                    this.scoreFirst = masterAfter;
                    this.scoreSecond = masterBefore;
                } else {
                    this.scoreFirst = masterBefore;
                    this.scoreSecond = masterAfter;
                }
            }

            this.forFirst = this.totalFirst - this.totalSecond;
            this.forSecond = this.totalSecond - this.totalFirst;

            if (this.match.add_info != null) {
                if (this.match.add_info.trim() != "") {
                    try {
                        let arrayInfo = JSON.parse(this.match.add_info);
                        arrayInfo.forEach(info => {
                            this.info += Object.values(info)[0] + " .";
                        });
                    } catch (e) {
                        this.info = this.match.add_info;
                    }
                }
            }
        },
        clearInfo() {
            this.total= 0;
            this.totalFirst= 0;
            this.totalSecond= 0;
            this.forFirst= 0;
            this.forSecond= 0;
            this.info= "";
            this.date= "";
            this.reverse= false;
            this.nameMatch= "";
            this.scoreFirst= "";
            this.scoreSecond= "";
        }
    }
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
