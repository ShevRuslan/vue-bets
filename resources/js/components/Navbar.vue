<template>
    <v-list nav dense color="wrapper-navbar">
        <v-list-item-group class="wrapper-navbar__items">
            <v-list-item class="navbar-item" to="/" color="false">
                <v-list-item-icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                    >
                        <path
                            id="Vector"
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M6.3488 11.2064C9.0304 11.2064 11.2064 9.0304 11.2064 6.3488C11.2064 3.6672 9.0304 1.4912 6.3488 1.4912C3.6672 1.4912 1.4912 3.6672 1.4912 6.3488C1.4912 9.0304 3.6672 11.2064 6.3488 11.2064ZM10.0288 11.52C8.992 12.2624 7.7184 12.6976 6.3488 12.6976C2.8416 12.6976 0 9.856 0 6.3488C0 2.8416 2.8416 0 6.3488 0C9.856 0 12.6976 2.8416 12.6976 6.3488C12.6976 7.7184 12.2624 8.992 11.52 10.0288L15.6928 14.2016C16.1024 14.6112 16.1024 15.2704 15.6928 15.68L15.6736 15.6992C15.264 16.1088 14.6048 16.1088 14.1952 15.6992L10.0288 11.52Z"
                            fill="#919CA7"
                        />
                    </svg>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Поиск</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item class="navbar-item" to="/line" color="#fff">
                <v-list-item-icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="16"
                        viewBox="0 0 18 16"
                        fill="none"
                    >
                        <g clip-path="url(#clip0)">
                            <path
                                d="M9.05039 0.00391745C11.9575 0.00391745 14.8645 0.00548638 17.7716 0.00077958C17.9387 0.000387346 18.0024 0.028236 18.0008 0.219254C17.9907 1.42184 17.9919 2.62443 17.9989 3.82702C18.0001 3.99333 17.9527 4.02941 17.7937 4.02941C11.954 4.02549 6.11379 4.02588 0.274008 4.0298C0.133356 4.0298 0.0890625 4.00196 0.0898396 3.84977C0.0968334 2.63424 0.0968334 1.41831 0.0898396 0.20278C0.0890625 0.0411797 0.128694 -0.000397122 0.290716 -4.88801e-06C3.21061 0.00548638 6.1305 0.00391745 9.05039 0.00391745Z"
                                fill="#919CA7"
                            />
                            <path
                                d="M8.95357 10.0647C6.04028 10.0647 3.12699 10.0628 0.213698 10.0686C0.043516 10.069 -0.00116634 10.029 -7.14317e-07 9.85487C0.00854722 8.65228 0.00971284 7.44969 -7.14317e-07 6.24749C-0.00155488 6.06314 0.0575036 6.04 0.217583 6.04C6.04416 6.04392 11.8707 6.04353 17.6969 6.03883C17.859 6.03883 17.8998 6.07883 17.8986 6.24161C17.8916 7.4442 17.8904 8.64679 17.8998 9.84899C17.9013 10.0365 17.8426 10.0686 17.6732 10.0682C14.7673 10.0635 11.8603 10.0651 8.95357 10.0647ZM0.933278 6.81192C0.796511 6.81153 0.747166 6.83231 0.749497 6.98842C0.7596 7.72033 0.758434 8.45224 0.749886 9.18376C0.748332 9.33202 0.787186 9.36575 0.931724 9.36536C6.28506 9.36144 11.638 9.36105 16.9913 9.36614C17.1545 9.36614 17.1802 9.31162 17.179 9.16611C17.1724 8.44753 17.1705 7.72857 17.1802 7.0096C17.1825 6.84055 17.1289 6.81113 16.9735 6.81153C14.3003 6.81663 11.6267 6.81506 8.95357 6.81506C6.2804 6.81506 3.60645 6.81623 0.933278 6.81192Z"
                                fill="#919CA7"
                            />
                            <path
                                d="M8.9532 15.9949C6.03991 15.9949 3.12623 15.9933 0.212936 15.9992C0.0439203 15.9996 -0.00076209 15.9628 0.000403537 15.7878C0.00856293 14.5852 0.00700876 13.3826 0.000792079 12.18C1.49947e-05 12.0243 0.0291557 11.9702 0.198172 11.9702C6.03175 11.9753 11.8649 11.9753 17.6985 11.9714C17.8605 11.9714 17.9009 12.0129 17.8998 12.1753C17.8924 13.3779 17.8924 14.5805 17.899 15.7831C17.8998 15.9455 17.8745 16.0008 17.6935 16.0004C14.7802 15.993 11.8665 15.9949 8.9532 15.9949ZM16.9739 15.2948C17.1305 15.2952 17.1817 15.2618 17.1794 15.0943C17.1697 14.3758 17.1693 13.6564 17.1794 12.9378C17.1817 12.7672 17.1281 12.7374 16.9731 12.7394C16.2481 12.748 15.5231 12.7433 14.798 12.7433C10.1822 12.7433 5.56666 12.7445 0.950778 12.7398C0.79303 12.7398 0.747182 12.7715 0.749902 12.9382C0.760392 13.6505 0.760781 14.3628 0.749125 15.0751C0.746016 15.2571 0.798858 15.2952 0.970982 15.2952C3.63794 15.2897 6.30528 15.2912 8.97262 15.2912C11.6396 15.2912 14.3069 15.2901 16.9739 15.2948Z"
                                fill="#919CA7"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0">
                                <rect width="18" height="16" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Линия</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-menu v-if="this.$route.path == '/'" offset-y content-class="menu elevation-1" z-index="0">
                <template v-slot:activator="{ on, attrs }">
                    <v-list-item class="navbar-item" color="false">
                        <v-list-item-icon v-on="on" v-bind="attrs">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="19"
                                height="16"
                                viewBox="0 0 19 16"
                                fill="none"
                            >
                                <g clip-path="url(#clip0)">
                                    <path
                                        d="M5.01891 13.6677C5.44436 13.2423 5.86231 12.8243 6.28067 12.406C7.32492 13.4227 8.56626 14.0469 10.0285 14.1969C11.5282 14.3507 12.9145 14.0019 14.1567 13.1531C15.4718 12.2543 16.3389 11.0192 16.7181 9.46864C17.0519 8.10312 16.9365 6.76302 16.3552 5.4775C15.7426 4.12281 14.7692 3.10398 13.4375 2.43726C12.0899 1.76263 10.6777 1.61553 9.2134 1.95264C8.27291 2.16891 7.43659 2.60394 6.69445 3.21357C6.07107 3.7257 5.56562 4.34366 5.18476 5.05497C4.69472 5.97004 4.44262 6.9497 4.44553 7.99561C5.32852 7.99561 6.21442 7.99561 7.11574 7.99561C5.91398 9.20237 4.72222 10.3991 3.52505 11.6013C3.51754 11.583 3.51379 11.5696 3.50671 11.5584C3.47171 11.5055 3.44254 11.4459 3.39837 11.4017C2.28245 10.2833 1.16486 9.16612 0.0472795 8.04895C0.0335284 8.0352 0.0156104 8.02561 -0.000640869 8.01436C0.00269272 8.00936 0.00602631 8.00478 0.0089432 7.99978C0.891094 7.99978 1.77283 7.99978 2.65915 7.99978C2.70082 5.69502 3.53505 3.73361 5.20892 2.15224C6.40902 1.01923 7.84121 0.328347 9.4755 0.0916617C11.5257 -0.205028 13.43 0.216255 15.1476 1.37635C16.6948 2.42143 17.7574 3.85112 18.3066 5.63709C18.8462 7.39182 18.7912 9.14237 18.1328 10.8608C17.4736 12.5806 16.3427 13.9157 14.768 14.8661C13.42 15.68 11.9474 16.055 10.3772 15.9929C8.29583 15.9116 6.51069 15.1228 5.01891 13.6677Z"
                                        fill="#919CA7"
                                    />
                                    <path
                                        d="M14.224 10.072C14.009 10.435 13.7973 10.7913 13.5848 11.1496C13.4489 11.0692 13.3152 10.9909 13.1818 10.9117C13.0106 10.81 12.8389 10.7083 12.668 10.6062C12.4422 10.4716 12.2167 10.3358 11.9905 10.2016C11.7671 10.0691 11.5421 9.93911 11.3188 9.8066C11.0587 9.65242 10.8 9.49574 10.5404 9.34156C10.2987 9.19822 10.0566 9.0557 9.81365 8.91444C9.78407 8.89736 9.7724 8.87902 9.7724 8.84444C9.77323 7.39432 9.77323 5.94421 9.77323 4.4941C9.77323 4.48118 9.77323 4.46785 9.77323 4.45201C10.2195 4.45201 10.6621 4.45201 11.1121 4.45201C11.1121 4.4716 11.1121 4.49243 11.1121 4.51368C11.1121 5.72211 11.1129 6.93054 11.11 8.13897C11.11 8.21064 11.1333 8.24689 11.1929 8.28106C11.445 8.42649 11.6938 8.57733 11.9438 8.72526C12.1688 8.85819 12.3947 8.98987 12.6197 9.12321C12.8685 9.2703 13.1164 9.41948 13.3656 9.56658C13.616 9.71451 13.8673 9.86118 14.1177 10.0087C14.1527 10.0283 14.1873 10.0499 14.224 10.072Z"
                                        fill="#919CA7"
                                    />
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <rect
                                            width="18.6731"
                                            height="16"
                                            fill="white"
                                        />
                                    </clipPath>
                                </defs>
                            </svg>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title
                                class="ma-0"
                                v-on="on"
                                v-bind="attrs"
                                >История</v-list-item-title
                            >
                        </v-list-item-content>
                    </v-list-item>
                </template>
                <v-list
                    v-for="(item, index) in getHistory"
                    :key="index"
                    class="menu__content"
                >
                    <span class="menu__content-date">
                        {{ item.date }}
                        <v-btn
                            text
                            class="clear-history"
                            x-small
                            color="#4D72C0"
                            v-if="index == 0"
                            @click="clearHistorySearch"
                        >
                            Очистить историю
                        </v-btn>
                    </span>
                    <v-list-item
                        v-for="(match, index) in item.matches"
                        :key="index"
                        class="menu__content-item"
                        dense
                        @click="getMatch(match)"
                    >
                        <v-list-item-title>
                            <span class="match-name">
                                {{ match.matchName }}
                            </span>
                            <span class="match-champ">{{
                                match.champName
                            }}</span>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-menu v-if="this.$route.path == '/line'" offset-y content-class="menu elevation-1" z-index="0">
                <template v-slot:activator="{ on, attrs }">
                    <v-list-item class="navbar-item" color="#fff">
                        <v-list-item-icon>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="17"
                                height="16"
                                viewBox="0 0 17 16"
                                fill="none"
                            >
                                <g clip-path="url(#clip0)">
                                    <path
                                        d="M8.12113 0.00316025C9.65055 0.00316025 11.1796 0.00552202 12.709 -0.000213714C12.8501 -0.000888506 12.8757 0.0436478 12.8646 0.170171C12.8464 0.376995 12.8528 0.586518 12.8329 0.793004C12.8201 0.924589 12.8535 0.963726 12.9904 0.962377C13.7718 0.955292 14.5536 0.965076 15.3347 0.953267C15.5398 0.950231 15.6893 1.01838 15.8246 1.15942C16.08 1.42596 16.2352 1.74581 16.2497 2.10784C16.3047 3.4915 16.0432 4.79654 15.1653 5.90928C14.4402 6.82834 13.4591 7.14212 12.317 7.00278C12.1503 6.98253 11.982 6.95622 11.8214 6.90831C11.7002 6.8722 11.6425 6.90156 11.5825 7.00615C11.3443 7.42351 11.0528 7.79903 10.6921 8.11989C10.4461 8.33886 10.1739 8.51499 9.86311 8.62363C9.77809 8.65332 9.75109 8.6911 9.75278 8.77815C9.75818 9.0366 9.75177 9.29538 9.75616 9.55383C9.75751 9.64054 9.74637 9.68406 9.64077 9.68372C8.63431 9.68001 7.62786 9.68069 6.62174 9.68372C6.53368 9.68406 6.50501 9.65876 6.50669 9.57036C6.51175 9.30618 6.5077 9.042 6.50872 8.77782C6.50905 8.71371 6.50804 8.66276 6.42808 8.6351C5.79512 8.41647 5.34706 7.96705 4.96176 7.44342C4.85548 7.29901 4.75628 7.14853 4.66653 6.99333C4.61289 6.90021 4.56397 6.87726 4.45364 6.90493C3.82304 7.06283 3.18705 7.09995 2.55612 6.91202C1.67923 6.65087 1.08035 6.05706 0.664003 5.26822C0.143064 4.28134 -0.0465529 3.21854 0.00945489 2.10986C0.0253125 1.79507 0.144751 1.50862 0.345501 1.26198C0.506777 1.06393 0.687284 0.943145 0.97407 0.95158C1.73794 0.974186 2.50315 0.955966 3.26769 0.961027C3.38881 0.961702 3.43639 0.941796 3.42289 0.8065C3.4013 0.58888 3.40973 0.368223 3.39016 0.149927C3.37937 0.0288023 3.41412 -0.000213714 3.53288 0.000123682C4.90474 0.00417243 6.27659 0.00282285 7.64844 0.00316025C7.80634 0.00316025 7.96357 0.00316025 8.12113 0.00316025ZM12.2569 15.9981C12.3895 15.9984 12.4253 15.9657 12.4223 15.8324C12.4128 15.439 12.4084 15.0449 12.4243 14.6522C12.4317 14.47 12.3976 14.3729 12.1969 14.3685C12.123 14.3668 12.0471 14.3239 11.9769 14.2905C11.6996 14.1589 11.4759 13.9545 11.2437 13.7588C10.2083 12.8853 9.69947 11.7584 9.62457 10.4216C9.61782 10.3015 9.56823 10.2897 9.47038 10.29C8.57088 10.2927 7.67172 10.2941 6.77222 10.2887C6.66156 10.288 6.64739 10.3295 6.63996 10.4223C6.5907 11.0296 6.46857 11.6207 6.23037 12.1848C5.91186 12.9389 5.33795 13.4828 4.73401 14C4.49784 14.2025 4.235 14.3671 3.91313 14.3958C3.8109 14.4049 3.83553 14.4731 3.83553 14.5291C3.83418 14.9505 3.84228 15.3726 3.83114 15.7936C3.82709 15.9502 3.85813 16.0001 4.02784 15.9991C5.39362 15.991 6.75974 15.9947 8.12552 15.9947C9.50277 15.9951 10.8797 15.993 12.2569 15.9981ZM1.24972 1.80182C1.13467 1.79946 1.09385 1.83151 1.09115 1.95027C1.08237 2.35481 1.0817 2.75901 1.12084 3.1622C1.17786 3.75062 1.28346 4.3279 1.53314 4.8701C1.99199 5.86676 2.97753 6.29425 3.98871 5.93964C4.09667 5.90185 4.12164 5.86137 4.07811 5.75205C3.91853 5.35021 3.79909 4.93555 3.71879 4.51111C3.56055 3.67538 3.53862 2.82649 3.48497 1.98098C3.47654 1.84669 3.44921 1.79642 3.30582 1.80114C2.96909 1.8116 2.6317 1.80452 2.29464 1.80452C1.94645 1.80452 1.59792 1.8089 1.24972 1.80182ZM12.9439 1.80216C12.8346 1.80013 12.7745 1.81936 12.7823 1.94386C12.7866 2.01606 12.7708 2.08928 12.7664 2.16216C12.6929 3.39534 12.6473 4.63324 12.1658 5.79895C12.1361 5.87048 12.1628 5.89814 12.2279 5.92142C12.7155 6.09619 13.2033 6.13162 13.6882 5.91974C14.2904 5.65657 14.6396 5.16869 14.8488 4.56914C15.1501 3.70642 15.1963 2.81198 15.1606 1.90844C15.1565 1.80958 15.111 1.80351 15.0347 1.80384C14.6862 1.8062 14.3377 1.80485 13.9891 1.80485C13.6406 1.80452 13.2921 1.80857 12.9439 1.80216Z"
                                        fill="#919CA7"
                                    />
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <rect
                                            width="16.2571"
                                            height="16"
                                            fill="white"
                                        />
                                    </clipPath>
                                </defs>
                            </svg>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title v-on="on" v-bind="attrs"
                                >Турниры</v-list-item-title
                            >
                        </v-list-item-content>
                    </v-list-item>
                </template>
                <v-list class="menu__content">
                    <v-list-item
                        v-for="(champ, index) in getLineChamps"
                        :key="index"
                        class="menu__content-item"
                        dense
                        @click="changeLineChamp(champ)"
                    >
                        <v-list-item-icon class="wrapper__champ-img">
                            <template v-if="typeof champ.img == 'string'">
                                <img
                                    class="champ-img"
                                    :src="
                                        'https://cdn.1xstavka.ru/genfiles/logo-champ/' +
                                            champ.img
                                    "
                                />
                            </template>
                            <template v-else-if="champ.img == 1">
                                <img class="champ-img" src="img/ru.png" />
                            </template>
                            <template v-else-if="champ.img == 2">
                                <img class="champ-img" src="img/uk.png" />
                            </template>
                            <template v-else-if="champ.img == 15">
                                <img class="champ-img" src="img/ar.png" />
                            </template>
                            <template v-else-if="champ.img == 204">
                                <img class="champ-img" src="img/cz.png" />
                            </template>
                            <template v-else-if="champ.img == 53">
                                <img class="champ-img" src="img/ge.png" />
                            </template>
                        </v-list-item-icon>
                        <v-list-item-title class="wrapper__item-champ">
                            <div class="champ-name">
                                {{ champ.champName }}
                            </div>
                            <div class="champ-count">
                                {{ champ.countMatches }}
                            </div>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-list-item-group>
    </v-list>
</template>

<script>
import { mapGetters } from "vuex";
import { mapMutations } from "vuex";
export default {
    name: "Navbar",
    data: () => ({}),
    methods: {
        ...mapMutations(["setHistory", "setCurrentLineChamps"]),
        getMatch(item) {
            const data = {
                player1: item.player1,
                player2: item.player2,
                champName: item.champName,
                countMatches: item.countMatches
            };
            console.log(item);
            this.$emit("search", data);
        },
        clearHistorySearch() {
            localStorage.clear();
            this.setHistory([]);
        },
        changeLineChamp({champName}) {
            this.setCurrentLineChamps(champName);
        }
    },
    computed: {
        ...mapGetters(["getHistory", "getLineChamps"])
    }
};
</script>

<style lang="scss">
.wrapper-navbar {
    .wrapper-navbar__items {
        display: flex;
        .navbar-item {
            margin-right: 32px;
            color: transparent !important;
            height: 100%;
            padding-left: 0px;
            .v-list-item__title {
                font-style: normal;
                font-weight: normal;
                font-size: 15px;
                line-height: 18px;
                /* identical to box height */
                color: #919ca7;
            }
            .v-list-item__icon {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-right: 5px;
            }
        }
        .theme--light.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
            color: transparent !important;
        }
        a.v-item--active {
            .v-list-item__icon {
                svg path {
                    fill: #3688fc;
                }
            }
            .v-list-item__content {
                .v-list-item__title {
                    color: #3688fc;
                }
            }
        }
    }
}
.menu {
    font-size: 14px;
    max-height: 350px;
    overflow-y: auto;
    top: 125px !important;
    padding-bottom: 24px;
    .menu__content {
        padding: 24px;
        padding-bottom: 0px;
        .menu__content-date:first-child {
            display: flex;
            justify-content: space-between;
        }
        .menu__content-date {
            color: #474d56;
            font-weight: bold;
            margin-bottom: 6px;
            .clear-history {
                text-transform: none !important;
                font-style: normal;
                font-weight: normal;
                font-size: 13px;
                line-height: 15px;
                letter-spacing: 0em;
            }
        }
        .menu__content-item {
            padding: 0px;
            min-height: 30px;
            padding-right: 10px;
            .match-name {
                font-size: 14px;
                font-weight: 500;
                line-height: 14px;
                color: #474d56;
            }
            .match-champ {
                line-height: 13px;
                color: #f0ac0e;
                padding-left: 10px;
                line-height: 15px;
            }
            .wrapper__champ-img {
                margin-right: 12px;
                .champ-img {
                    width: 28px;
                    height: auto;
                    object-fit: contain;
                }
            }
            .wrapper__item-champ {
                display: flex;
                justify-content: space-between;
                .champ-count {
                    font-size: 14px;
                    line-height: 16px;
                    color: #919ca7;
                    margin-left: 6px;
                }
            }
        }
    }
}
.menu::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}
.menu::-webkit-scrollbar-button {
    width: 0px;
    height: 0px;
}
.menu::-webkit-scrollbar-thumb {
    background: #474d56;
    border: 0px none #ffffff;
    border-radius: 0px;
}
.menu::-webkit-scrollbar-thumb:hover {
    background: #474d56;
}
.menu::-webkit-scrollbar-thumb:active {
    background: #474d56;
}
.menu::-webkit-scrollbar-track {
    background: #c8cacc;
    border: 0px none #ffffff;
    border-radius: 0px;
}
.menu::-webkit-scrollbar-track:hover {
    background: #c8cacc;
}
.menu::-webkit-scrollbar-track:active {
    background: #c8cacc;
}
.menu::-webkit-scrollbar-corner {
    background: transparent;
}
</style>
