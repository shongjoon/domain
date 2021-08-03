<template>
    <div class="">
        <div class="flex">
            <div class="pr-4 flex1">
                <el-card class="box-card" style="height: 512px; width: 401px">
                    <div slot="header" class="clearfix">
                        <span>구입 관리</span>
                    </div>
                    <div class="text item flex flex-col">
                        <div class="flex">
                            <span class="w-1/5">계정 : </span>
                            <span class="w-4/5">
                                <el-input
                                    placeholder="Please input"
                                    v-model="account"
                                ></el-input>
                            </span>
                        </div>

                        <div class="flex mt-3">
                            <span class="w-1/5"> 비고 : </span>
                            <span class="w-4/5">
                                <el-input
                                    placeholder="Please input"
                                    v-model="notice"
                                ></el-input>
                            </span>
                        </div>
                        <div class="flex mt-3">
                            <span class="w-1/5">구입갯수 : </span>
                            <span class="w-4/5">
                                <el-input
                                    placeholder="Please input"
                                    v-model="get_no"
                                ></el-input>
                            </span>
                        </div>
                        <div class="flex mt-3">
                            <span class="w-1/5">금액 : </span>
                            <span class="w-4/5">
                                <el-input
                                    placeholder="Please input"
                                    v-model="account_coin"
                                ></el-input>
                            </span>
                        </div>
                    </div>
                    <div class="text-center">
                        <el-button @click="" size="small" type="primary"
                            >등록</el-button
                        >
                    </div>
                </el-card>
            </div>
            <div class="w-full">
                <div class="w-full h-8 bg-green-300 text-center pt-2 text-xl">
                    total list
                </div>
                <Table
                    height="480"
                    :columns="columns1"
                    :data="account_list"
                ></Table>
            </div>
        </div>
        <div>
            <div>
                <Table
                    stripe
                    height="480"
                    :columns="columns2"
                    :data="coin_list"
                ></Table>
                <Page :current="1" :total="coin_list.length" simple />
            </div>
            <div></div>
        </div>
        <div height="300">
            <ul
                class="infinite-list"
                v-infinite-scroll="load"
                style="overflow: auto"
            >
                <li v-for="i in count" :key="i" class="infinite-list-item">{{ i }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            account: "",
            notice: "",
            get_no: "",
            account_coin: "ttest",
            count: 0,
            columns1: [
                {
                    title: "계정",
                    key: "account",
                },
                {
                    title: "비고",
                    key: "notice",
                },
                {
                    title: "금액",
                    key: "coin",
                },
            ],
            columns2: [
                {
                    title: "계정",
                    key: "account",
                },
                {
                    title: "수량",
                    key: "get_no",
                },
                {
                    title: "비고",
                    key: "notice",
                },
                {
                    title: "금액",
                    key: "account_coin",
                },
                {
                    title: "date",
                    key: "updated_at",
                },
            ],
            account_list: [],
            coin_list: [],
            coin_list_total: 0,
        };
    },
    methods: {
        load() {
            this.count += 2
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    async created() {
        const res = await this.callApi("get", "app/get_coins");
        this.account_list = res.data.account_coin;
        this.coin_list = res.data.coin_list;
        console.log(this.coin_list.length);
    },
};
</script>
<style scoped>
.text {
    font-size: 14px;
}

.item {
    margin-bottom: 18px;
}

.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}
.clearfix:after {
    clear: both;
}

.box-card {
    width: 480px;
}
.box-card div.text .flex span {
    text-align: center;
    align-self: center;
}
</style>