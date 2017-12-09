<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb>
                <el-breadcrumb-item>工资管理</el-breadcrumb-item>
                <el-breadcrumb-item>工资列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-form :inline="true" @keydown.enter.native="search">
            <!--<el-form-item>-->
                <!--<router-link :to="{ path: 'edit' }">-->
                    <!--<el-button><i class="ion-plus"></i> 录入工资</el-button>-->
                <!--</router-link>-->
            <!--</el-form-item>-->
            <el-form-item>
                <router-link :to="{ path: 'import' }">
                    <el-button><i class="ion-android-upload"></i> 导入工资</el-button>
                </router-link>
            </el-form-item>

            <el-form-item label="关键字">
                <el-input v-model="keyword" placeholder="工号 \ 姓名"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search" @click="search">查询</el-button>
            </el-form-item>
        </el-form>

        <el-table :data="wages" border>
            <el-table-column prop="code" label="工号"></el-table-column>
            <el-table-column prop="name" label="姓名"></el-table-column>
            <el-table-column prop="wage_should" label="应发工资"></el-table-column>
            <el-table-column prop="wage_garnishment" label="扣发工资"></el-table-column>
            <el-table-column prop="wage_actual" label="实发工资"></el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <router-link :to="{ path: 'detail', query: { id: scope.row.id } }">
                        <el-button size="small" icon="more">详情</el-button>
                    </router-link>
                    <el-button size="small" type="danger" icon="delete" @click="del(scope.row.id)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-pagination
                style="padding: 1rem 0;"
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="pagination.current"
                :page-sizes="[10, 20, 50, 100]"
                :page-size="pagination.pageSize"
                layout="total, sizes, prev, pager, next, jumper"
                :total="pagination.total">
        </el-pagination>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                wages: [],
                keyword: '',
                pagination: {
                    current: 1,
                    total: 0,
                    pageSize: 20
                }
            }
        },
        methods: {
            search() {
                let self = this;
                let params = {
                    page: self.pagination.current,
                    pageSize: self.pagination.pageSize,
                    keyword: self.keyword
                };
                axios.get('/admin/wage/list', {
                    params: params
                }).then((res) => {
                    if (res) {
                        self.wages = res.data.data;
                        self.pagination.total = res.data.total;
                    } else {
                        console.log(res.data.msg);
                    }
                });
            },
            del(id) {
                let self = this;
                this.$confirm('确认删除吗？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post('/admin/wage/del', {
                        id: id
                    }).then((res) => {
                        if (res.data.code === 0){
                            self.$message({
                                title: '提示',
                                message: res.data.msg,
                                type: 'success'
                            });
                            self.search();
                        } else {
                            self.$message({
                                title: '提示',
                                message: res.data.msg,
                                type: 'warning'
                            });
                        }
                    });
                }).catch(() => {});
            },
            handleSizeChange(val) {
                this.pagination.pageSize = val;
                this.search();
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                this.pagination.current = val;
                this.search();
                console.log(`当前页: ${val}`);
            }
        },
        mounted() {
            this.search();
        }
    }
</script>

<style>

</style>