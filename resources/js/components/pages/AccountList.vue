<template>
    <div>
        <el-card class="box-card" style="height: 280px; width: 600px">
            <div slot="header" class="clearfix">
                <span>계정 추가</span>
            </div>
            <div class="text item flex flex-col">
                <div class="flex">
                    <span class="w-1/5 self-center text-center"
                        >Email address :
                    </span>
                    <span class="w-4/5">
                        <el-input
                            v-model="add.account"
                            placeholder="Please input"
                        ></el-input>
                    </span>
                </div>
                <div class="flex mt-3">
                    <span class="w-1/5 self-center text-center">
                        API KEY :
                    </span>
                    <span class="w-4/5">
                        <el-input
                            v-model="add.api_key"
                            placeholder="Please input"
                        ></el-input>
                    </span>
                </div>
                <div class="flex mt-3">
                    <span class="w-1/5 self-center text-center">
                        SITE NAME :
                    </span>
                    <Select
                        v-model="add.site_name"
                        placeholder="선택"
                        style="width: 80%"
                    >
                        <Option
                            v-for="item in sites"
                            :value="item.name"
                            :key="item.name"
                            >{{ item.name }}</Option
                        >
                    </Select>
                </div>
            </div>
            <div class="text-center">
                <el-button @click="addAccount" class="mt-2" type="primary"
                    >Add Account
                </el-button>
            </div>
        </el-card>
        <div>
            <div class="mt-1 mb-1 p-2 bg-orange-300">Site List</div>
            <Table border :columns="columns7" :data="nowData"></Table>
            <Page
                :total="accountList.length"
                :pageSize="pageSize"
                @on-change="changePage"
                simple
            />
        </div>
    </div>
</template>
<style scoped>
</style>
<script>
export default {
    data() {
        return {
            add: {
                account: "",
                api_key: "",
                site_name: "",
            },
            nowData: [],
            accountList: [],
            pageSize: 15,
            sites: [],
            columns7: [
                {
                    title: "#",
                    key: "id",
                    width: 60,
                },
                {
                    title: "Site Name",
                    key: "site_name",
                },
                {
                    title: "Account",
                    key: "account",
                },
                {
                    title: "Api Key",
                    key: "api_key",
                },
                {
                    title: "Count",
                    key: "count",
                    width: 65,
                },
                {
                    title: "Updated At",
                    key: "updated_at",

                },
                {
                    title: "Domain",
                    key: 1,
                    width: 110,
                    render: (h, params) => {
                        return h("div", [
                            h(
                                "Button",
                                {
                                    props: {
                                        type: "primary",
                                        // size: "middle",
                                    },
                                    style: {
                                        marginRight: "5px",
                                    },
                                    on: {
                                        click: () => {
                                            this.showDomains(params.row.id);
                                        },
                                    },
                                },
                                "Domains"
                            ),
                        ]);
                    },
                },
                {
                    title: "Etc",
                    key: 1,
                    width: 110,
                    render: (h, params) => {
                        return h("div", [
                            h(
                                "Button",
                                {
                                    props: {
                                        type: "success",
                                        // size: "middle",
                                    },
                                    style: {},
                                    on: {
                                        click: () => {
                                            this.updateAccountInfo(params.row.id);
                                        },
                                    },
                                },
                                "update"
                            ),
                        ]);
                    },
                },
            ],
        };
    },
    mounted() {},
    methods: {
        changePage(index) {
            let _start = (index - 1) * this.pageSize;
            let _end = index * this.pageSize;
            this.nowData = this.accountList.slice(_start, _end);
        },
        showDomains(index) {
            let lint_domain = this.$router.resolve({
                path: "/DomainList",
                query: { account_id: index },
            });
            window.open(lint_domain.href, "_blank");
        },
        async updateAccountInfo(id) {
            const res = await this.callApi("post", "app/update_account", {account_id:id})
            
            if(res.data.success) {
                this.s(res.data.success)
            }
            if(res.data.error) {
                this.e(res.data.error)
            }
        },
        async addAccount() {
            const res = await this.callApi("post", "app/add_account", this.add);
            if (res.status === 200) {
                this.s();
            }
        },
    },
    async created() {
        const res = await this.callApi("get", "app/get_accounts");
        console.log('res.data',res.data);
        if (res.status === 200) {
            this.accountList = res.data;
            this.nowData = this.accountList.slice(0, this.pageSize);
        } else {
            this.swr();
        }

        const sites = await this.callApi("get", "app/get_site");
        if (sites.status === 200) {
            this.sites = sites.data;
        } else {
            this.swr();
        }
    },
};
</script>
