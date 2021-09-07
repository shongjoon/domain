<template>
    <div>
        <el-card class="box-card" style="height: 220px; width: 600px">
            <div slot="header" class="clearfix">
                <span>Site Add</span>
            </div>
            <div class="text item flex flex-col">
                <div class="flex">
                    <span class="w-1/5 self-center text-center">Name : </span>
                    <span class="w-4/5">
                        <el-input
                            placeholder="Please input"
                            v-model="site.name"
                        ></el-input>
                    </span>
                </div>

                <div class="flex mt-3">
                    <span class="w-1/5 self-center text-center">
                        Description :
                    </span>
                    <span class="w-4/5">
                        <el-input
                            placeholder="Please input"
                            v-model="site.description"
                        ></el-input>
                    </span>
                </div>
            </div>
            <div class="text-center">
                <el-button
                    class="mt-2"
                    size="small"
                    type="primary"
                    @click="addSite"
                    >Add Site
                </el-button>
            </div>
        </el-card>
        <div>
            <div class="mt-1 mb-1 p-2 bg-orange-300">Site List</div>
            <Table
                border
                :columns="columns7"
                :data="nowData"
                id="simpledatatable"
            ></Table>
            <Page
                :total="siteList.length"
                :pageSize="pageSize"
                @on-change="changePage"
                simple
            />
        </div>
    </div>
</template>

<style scoped>
/* .el-card__body {
    padding: 10px;
} */
</style>

<script>
export default {
    data() {
        return {
            nowData: [],
            siteList: [],
            pageSize: 15,
            site: {},
            columns7: [
                {
                    title: "Id",
                    key: "id",
                },
                {
                    title: "Name",
                    key: "name",
                },
                {
                    title: "Description",
                    key: "description",
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
        const res = await this.callApi("get", "app/get_site");
        if (res.status === 200) {
            this.siteList = res.data;
            this.nowData = this.siteList.slice(0, this.pageSize);
        } else {
            this.swr();
        }
    },
    methods: {
        async addSite() {
            const res = await this.callApi("post", "app/add_site", this.site);
            if (res.status === 200) {
                this.s();
            } else {
                this.swr();
            }
        },
        changePage(index) {
            let _start = (index - 1) * this.pageSize;
            let _end = index * this.pageSize;
            this.nowData = this.siteList.slice(_start, _end);
        },
        show(index) {
            let lint_domain = this.$router.resolve({
                path: "/DomainList",
                query: { id: index },
            });
            window.open(lint_domain.href, "_blank");

            // this.$Modal.info({
            //     title: "User Info",
            //     content: `Name：${this.data6[index].name}<br>Age：${this.data6[index].age}<br>Address：${this.data6[index].address}`,
            // });
        },
    },
};
</script>