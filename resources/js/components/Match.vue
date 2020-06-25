<template>
    <tr>
        <td>
            <div class="slot-name-match">
                        <div class="slot-date-champ">
                            <div class="date">
                                {{ this.date }}
                            </div>
                            <span class="champ-name">{{ match.champName }}</span>
                        </div>
                        <div class="match-player">
                            {{ this.nameMatch }}
                        </div>
        </div>
        </td>
        <td class="text-left number-info">
            <template v-if="scoreFirst > scoreSecond">
                <div class="scores-match">
                    <p style="color:#33CC33">
                        {{ this.scoreFirst }}:{{ this.scoreSecond }}
                    </p>
                </div>
            </template>
            <template v-else>
                <div class="scores-match ">
                    <p style="color:#FF0000">
                        {{ this.scoreFirst }}:{{ this.scoreSecond }}
                    </p>
                </div>
            </template>
        </td>
        <td class="text-left number-info">{{ this.forFirst }}</td>
        <td class="text-left number-info">{{ this.totalFirst }}:{{ this.totalSecond}}</td>
        <td class="text-left number-info">{{ this.forSecond }}</td>
        <td class="text-left number-info">{{ this.total }}</td>
    </tr>
</template>

<script>
export default {
    props: {
        name: String,
        match: Object,
        player: String,
    },
    name: 'Match',
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
                    let nameMatchArray = first.split(' ');
                    let family = nameMatchArray[1];
                    let name = nameMatchArray[0];
                    let country = nameMatchArray[2];
                    this.nameMatch = `${family} ${name} ${country}`;
                } else {
                    let nameMatchArray = second.split(' ');
                    let family = nameMatchArray[1];
                    let name = nameMatchArray[0];
                    let country = nameMatchArray[2];
                    this.nameMatch = `${family} ${name} ${country}`
                }
            }

            const dateInMS = Date.parse(this.match.date);
            const date = new Date(dateInMS);
            const day = date.getDate();
            const year = date.getFullYear() - 2000;
            let month = date.getMonth() + 1;
            if (parseInt(month) < 10) month = '0' + month;
            this.date = `${day}.${month}.${year}`;

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

            if(this.forFirst > 0)  this.forFirst = '+' + this.forFirst;

            if(this.forSecond > 0)  this.forSecond = '+' + this.forSecond;

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

<style scoped lang="scss">
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
    font-style: normal;
    font-weight: normal;
    font-size: 12px;
    line-height: 14px;
}
.scores-match p {
    margin-bottom: 0px;
}

.match-player {
        font-weight:  bold;
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
