<template>
    <div>
        <el-card class="box-card" style="height: 220px; width: 600px">
            <div slot="header" class="clearfix">
                <span>도메인추가</span>
            </div>
            <div class="text item flex flex-col">
                <div class="flex">
                    <span class="w-1/5 self-center text-center"
                        >Account :
                    </span>
                    <span class="w-4/5">
                        <Select
                            v-model="addSiteName.account"
                            placeholder="선택"
                        >
                            <Option
                                v-for="item in accounts"
                                :value="item.account"
                                :key="item.account"
                                >{{ item.account }}</Option
                            >
                        </Select>
                    </span>
                </div>

                <div class="flex mt-3">
                    <span class="w-1/5 self-center text-center">
                        Domain :
                    </span>
                    <span class="w-4/5">
                        <el-input
                            placeholder="Please input"
                            v-model="addSiteName.name"
                        ></el-input>
                    </span>
                </div>
            </div>
            <div class="text-center">
                <el-button
                    class="mt-2"
                    size="small"
                    type="primary"
                    @click="cloudAddDomain"
                    >Add Domain
                </el-button>
            </div>
        </el-card>
        <div>
            <div class="mt-1 mb-1 p-2 bg-orange-300">Site List</div>
            <Table border :columns="columns7" :data="nowData"></Table>
            <Page
                :total="domains.length"
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
            domains: [],
            nowData: [],
            siteList: [],
            accounts: [],
            addSiteName: {},
            pageSize: 15,
            domainList: [],
            // addDomain: false, 이걸 왜 만들었는지 까먹음
            columns7: [
                {
                    title: "Id",
                    key: "id",
                    width: 60,
                },
                {
                    title: "Site",
                    key: "site_name",
                    width: 100,
                },
                {
                    title: "Domain",
                    key: "name",
                    width: 120,
                },
                {
                    title: "Get_id",
                    key: "get_id",
                },
                {
                    title: "Account",
                    key: "account_name",
                },
                {
                    title: "dns",
                    key: "get_id",
                },
                {
                    title: "Domains",
                    key: "action",
                    width: 150,
                    align: "center",
                    render: (h, params) => {
                        return h("div", [
                            h(
                                "Button",
                                {
                                    props: {
                                        type: "primary",
                                        size: "small",
                                    },
                                    style: {
                                        marginRight: "5px",
                                    },
                                    on: {
                                        click: () => {
                                            this.show(params.row.id);
                                        },
                                    },
                                },
                                "View Domains"
                            ),
                        ]);
                    },
                },
            ],
        };
    },
    async created() {
        console.log("created");
        const accounts = await this.callApi("get", "app/get_accounts");
        // this.addDomain = true;
        if (accounts.status === 200) {
            this.accounts = accounts.data;
        } else {
            this.swr();
        }

        this.domainList = await this.callApi("post", "app/domain_list", {
            id: this.$route.query.id,
            account_id: this.$route.query.account_id,
            page: this.pageSize,
        });

        // if (this.$route.query.id) {
        //     console.log(1111);
            
        // } else if (this.$route.query.account_id) {
        //     console.log(2222);
        //     this.domainList = await this.callApi("post", "app/domain_list", {
        //         account_id: this.$route.query.account_id,
        //     });
        // } else {
        //     console.log(3333);
        //     this.domainList = await this.callApi("post", "app/domain_list", {
        //         page: this.pageSize,
        //     });
        // }
        // console.log('11',this.$route.query.account_id);
        // console.log(this.domainList.data[0]['domains']);

        if (this.domainList.status === 200) {
            if(this.$route.query.id){
                this.nowData = this.domainList.data;
                
                // console.log('this.domains',this.domains);
            }else if(this.$route.query.id) {

            }
            // this.domains = this.domainList.data;
            // this.nowData = this.domains.slice(0, this.pageSize);
            // console.log('nowData',this.nowData);
        } else {
            this.swr();
        }

        // if (this.$route.query.id) {
        //     // this.addDomain = true;
        //     const site_domain = await this.callApi("post", "app/domain_list", {
        //         id: this.$route.query.id,
        //     });
        //     if (site_domain.status === 200) {
        //         this.domains = site_domain.data;
        //         this.nowData = this.domains.slice(0, this.pageSize);
        //     } else {
        //         this.swr();
        //     }
        // } else if (this.$route.query.account_id) {
        //     // this.addDomain = true;
        //     const account_domain = await this.callApi(
        //         "post",
        //         "app/domain_list",
        //         {
        //             account_id: this.$route.query.account_id,
        //         }
        //     );
        //     if (account_domain.status === 200) {
        //         this.domains = account_domain.data;
        //         this.nowData = this.domains.slice(0, this.pageSize);
        //     } else {
        //         this.swr();
        //     }
        // } else {
        //     const domain = await this.callApi("post", "app/domain_list", {
        //         page: this.pageSize,
        //     });
        //     if (domain.status === 200) {
        //         this.domains = domain.data;
        //         this.nowData = this.domains.slice(0, this.pageSize);
        //     } else {
        //         this.swr();
        //     }
        // }
    },
    methods: {
        changePage(index) {
            let _start = (index - 1) * this.pageSize;
            let _end = index * this.pageSize;
            this.nowData = this.domains.slice(_start, _end);
        },
        async cloudAddDomain() {
            const res = await this.callApi(
                "post",
                "app/cloud_add_domain",
                this.addSiteName
            );
            console.log("res", res);
            if (res.data.success) {
                this.s(res.data.success, "success");
            } else {
                this.e(res.data.error, "error");
            }
        },
    },
};
</script>