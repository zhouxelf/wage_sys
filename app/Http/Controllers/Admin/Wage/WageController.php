<?php

namespace App\Http\Controllers\Admin\Wage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Wage;
use Maatwebsite\Excel\Facades\Excel;

class WageController extends Controller
{
    /*
     * 获取工资列表
     */
    public function getList(Request $request)
    {
        $pageSize = $request->pageSize;
        $keyword = $request->keyword;
        $wages = Wage::getList($pageSize, $keyword);
        if (!empty($wages)) {
            return $wages;
        } else {
            return responseToJson(1, '工资加载失败');
        }
    }

    /*
     * 删除工资
     */
    public function del(Request $request)
    {
        $id = $request->id;
        $res = Wage::del($id);
        if ($res) {
            return responseToJson(0, '删除成功');
        } else {
            return responseToJson(1, '删除失败，请重试');
        }
    }

    /**
     * 导入工资
     * @param Request $request
     */
    public function import(Request $request)
    {
        return Wage::import($request);
    }

    /*
     * 下载模板
     */
    public function template()
    {
        Excel::create("工资模板", function ($excel) {
            $excel->sheet("用户模板", function ($sheet){
                $data = [
                    ['工号', '姓名', '工资年份', '工资月份', '底薪', '津贴', '奖金', '应发工资', '水电费', '暖气费', '房租', '个人所得税', '扣发工资', '实发工资'],
                ];
                $sheet->rows($data);
                $sheet->setWidth(array(
                    'A' => 10,
                    'B' => 10,
                    'C' => 10,
                    'D' => 10,
                    'E' => 10,
                    'F' => 10,
                    'G' => 10,
                    'H' => 10,
                    'I' => 10,
                    'J' => 10,
                    'K' => 10,
                    'L' => 10,
                    'M' => 10,
                    'N' => 10,
                ));
            });
        })->export("xls");
    }
}
