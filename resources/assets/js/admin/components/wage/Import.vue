<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="el-icon-arrow-left gm-home" @click="$router.go(-1)" style="cursor: pointer;margin-top: -2px;"></i>
            <el-breadcrumb>
                <el-breadcrumb-item>用户管理</el-breadcrumb-item>
                <el-breadcrumb-item>工资导入</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-form ref="form" :loading="loading">
            <el-form-item style="height: 300px;">
                <el-upload
                        style="text-align: center;height: 300px;"
                        class="upload-demo"
                        drag
                        accept=".xls,.xlsx,.csv"
                        name="files"
                        :data="csrf_token"
                        action="/admin/wage/import"
                        multiple
                        :before-upload="before"
                        :on-error="error"
                        :on-success="handleSuccess">
                    <i class="el-icon-upload"></i>
                    <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                    <div class="el-upload__tip" slot="tip">只能上传扩展名为 xls、xlsx 的 Excel 文件</div>
                </el-upload>
            </el-form-item>
            <el-form-item>
                <p style="text-align: center;margin-top: -2em;"><el-button type="text" @click="download_template">下载模版</el-button></p>
            </el-form-item>
        </el-form>

        <el-col v-if="error_bool" class="page-content">
            <el-row>
                <el-col :span="24">
                    <el-table :data="source" border v-loading="loading">
                        <el-table-column prop="code" label="工号" width="100"></el-table-column>
                        <el-table-column prop="name" label="姓名" width="100"></el-table-column>
                        <el-table-column prop="wage_year" label="工资年份" width="100"></el-table-column>
                        <el-table-column prop="wage_month" label="工资月份" width="100"></el-table-column>
                        <el-table-column prop="wage_base" label="底薪" width="100"></el-table-column>
                        <el-table-column prop="wage_allowance" label="津贴" width="100"></el-table-column>
                        <el-table-column prop="wage_bonus" label="奖金" width="100"></el-table-column>
                        <el-table-column prop="wage_should" label="应发工资" width="100"></el-table-column>
                        <el-table-column prop="water_electric" label="水电费" width="100"></el-table-column>
                        <el-table-column prop="heating_costs" label="暖气费" width="100"></el-table-column>
                        <el-table-column prop="house_rent" label="房租" width="100"></el-table-column>
                        <el-table-column prop="income_tax" label="个人所得税" width="100"></el-table-column>
                        <el-table-column prop="wage_garnishment" label="扣发工资" width="100"></el-table-column>
                        <el-table-column prop="wage_actual" label="实发工资" width="100"></el-table-column>
                        <el-table-column prop="reason" label="失败原因"></el-table-column>
                    </el-table>
                </el-col>
            </el-row>
        </el-col>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                csrf_token: {
                    _token: Laravel.csrfToken
                },
                error_bool: false,
                source: [],
                loading: false,
            }
        },
        methods: {
            before(file) {
                this.loading = true;
            },
            error(err, file, fileList) {
                this.loading = false;
            },
            handleSuccess(data) {
                let self = this;
                if (data.code === 1) {
                    self.$message({
                        message: data.msg,
                        type: 'warning'
                    });
                } else {
                    if (data.result.error === 0) {
                        self.$message({
                            message: "成功导入" + data.result.success + "条记录",
                            type: "success"
                        });
                        setTimeout(function () {
                            location.href = "/#/wage/list";
                        }, 2000);
                        self.error_bool = false;
                    } else {
                        self.$message({
                            message: "成功导入" + data.result.success + "条记录，失败" + data.result.error + "条记录",
                            type: 'warning'
                        });
                        self.source = data.result.error_data;
                        self.error_bool = true;
                    }
                    self.loading = false;
                }
            },
            download_template() {
                window.location.href = "/admin/wage/template"
            }
        }
    }
</script>