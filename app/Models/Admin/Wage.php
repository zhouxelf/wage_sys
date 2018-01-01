<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\User;
use Illuminate\Support\Facades\DB;

class Wage extends Model
{
    /**
     * @param $pageSize /每页显示数量
     * @param $keyword /关键字
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getList($pageSize, $keyword)
    {
        $query = self::where('status', '0');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'like', $keyword . '%')
                    ->orWhere('code', 'like', $keyword . '%');
            });
        }
        $result = $query->paginate($pageSize);
        return responseToPage($result);
    }

    /**
     * 删除工资
     * @param $id /工资
     * @return mixed
     */
    public static function del($id)
    {
        $wage = self::find($id);
        $wage->status = '1';
        return $wage->save();
    }

    /**
     * 导入工资
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function import(Request $request)
    {
        // 判断请求中是否包含 name=file 的上传文件
        if (!$request->hasFile('files')) {
            return responseToJson(1, '上传文件为空');
        }
        $file = $request->file('files');
        // 判断上传过程中是否出错
        if (!$file->isValid()) {
            return responseToJson(1, '文件上传出错');
        }
        $destPath = realpath(storage_path('app/tmp'));
        if (!file_exists($destPath)) {
            mkdir($destPath, 0777, true);
        }
        $fileName = get_session_user_id() .'and' . millisecond() . '.xls';
        if ($file->move($destPath,  $fileName) == false) {
            return responseToJson(1, '保存文件失败！');
        }

        // Excel 导入
        $filePath = 'storage/app/tmp/' . $fileName;

        $reader = Excel::load($filePath);
        $reader = $reader->getSheet(0);

        $result = $reader->toArray();
        if (empty($result)) {
            return responseToJson(1, '文件内容为空');
        }

        $success = 0;
        $error = 0;
        $error_data = array();
        $result_arr = array();

        for ($i = 1; $i < count($result); $i++) {
            if (!empty($result[$i][1])) {
                $code = $result[$i][0] ? $result[$i][0] : '';
                $name = $result[$i][1] ? $result[$i][1] : '';
                $wage_year = $result[$i][2] ? $result[$i][2] : '';
                $wage_month = $result[$i][3] ? $result[$i][3] : '';
                $wage_base = $result[$i][4] ? $result[$i][4] : 0;
                $wage_allowance = $result[$i][5] ? $result[$i][5] : 0;
                $wage_bonus = $result[$i][6] ? $result[$i][6] : 0;
                $wage_should = $result[$i][7] ? $result[$i][7] : 0;
                $water_electric = $result[$i][8] ? $result[$i][8] : 0;
                $heating_costs = $result[$i][9] ? $result[$i][9] : 0;
                $house_rent = $result[$i][10] ? $result[$i][10] : 0;
                $income_tax = $result[$i][11] ? $result[$i][11] : 0;
                $wage_garnishment = $result[$i][12] ? $result[$i][12] : 0;
                $wage_actual = $result[$i][13] ? $result[$i][13] : 0;

                $code = trim($code);
                $name = trim($name);
                $wage_year = trim($wage_year);
                $wage_month = trim($wage_month);
                $wage_base = trim($wage_base);
                $wage_allowance = trim($wage_allowance);
                $wage_bonus = trim($wage_bonus);
                $wage_should = trim($wage_should);
                $water_electric = trim($water_electric);
                $heating_costs = trim($heating_costs);
                $house_rent = trim($house_rent);
                $income_tax = trim($income_tax);
                $wage_garnishment = trim($wage_garnishment);
                $wage_actual = trim($wage_actual);

                $wage = [
                    'id' => 0,
                    'code' => $code,
                    'name' => $name,
                    'wage_year' => $wage_year,
                    'wage_month' => $wage_month,
                    'wage_base' => $wage_base,
                    'wage_allowance' => $wage_allowance,
                    'wage_bonus' => $wage_bonus,
                    'wage_should' => $wage_should,
                    'water_electric' => $water_electric,
                    'heating_costs' => $heating_costs,
                    'house_rent' => $house_rent,
                    'income_tax' => $income_tax,
                    'wage_garnishment' => $wage_garnishment,
                    'wage_actual' => $wage_actual,
                ];
                $find_res = User::where([
                    ['code', '=', $code],
                    ['name', '=', $name],
                    ['type', '=', 0],
                    ['status', '=', '0']
                ])->first();
                $find_res2 = self::where([
                    ['code', '=', $code],
                    ['wage_year', '=', $wage_year],
                    ['wage_month', '=', $wage_month],
                    ['status', '=', '0']
                ])->first();

                if (empty($find_res)) {
                    $error++;
                    $wage['reason'] = "工号不存在或工号与姓名不匹配";
                    array_push($error_data, $wage);
                } else if (!empty($find_res2)) {
                    $error++;
                    $wage['reason'] = "用户本月工资已存在";
                    array_push($error_data, $wage);
                } else {
                    $validate_info = self::validate($wage);
                    if (!empty($validate_info)) {
                        $error++;
                        $wage_temp = $wage;
                        $wage_temp['reason'] = $validate_info;
                        array_push($error_data, $wage_temp);
                    } else {
                        $_wage = new self;
                        $_wage->code = $code;
                        $_wage->name = $name;
                        $_wage->wage_year = $wage_year;
                        $_wage->wage_month = $wage_month;
                        $_wage->wage_base = $wage_base;
                        $_wage->wage_allowance = $wage_allowance;
                        $_wage->wage_bonus = $wage_bonus;
                        $_wage->wage_should = $wage_should;
                        $_wage->water_electric = $water_electric;
                        $_wage->heating_costs = $heating_costs;
                        $_wage->house_rent = $house_rent;
                        $_wage->income_tax = $income_tax;
                        $_wage->wage_garnishment = $wage_garnishment;
                        $_wage->wage_actual = $wage_actual;
                        $_wage->status = 0;
                        $_wage->creator = get_session_user_id();
                        $res = $_wage->save();
                        if ($res) {
                            $success++;
                        }
                    }
                }
            }
        }

        $result_arr['success'] = $success;
        $result_arr['error'] = $error;
        $result_arr['error_data'] = $error_data;
        return responseToJson(0, '导入成功', $result_arr);
    }

    /**
     * 工资信息验证
     * @param $wage /待验证工资信息
     * @return string 验证结果
     */
    public static function validate($wage)
    {
        $validate_info = "";
        $message = array(
            'required' => ':attribute不能为空',
            'regex' => ':attribute不符合要求',
        );
        $attributes = array(
            'wage_year' => '工资年份',
            'wage_month' => '工资月份',
            'wage_base' => '底薪',
            'wage_allowance' => '津贴',
            'wage_bonus' => '奖金',
            'wage_should' => '应发工资',
            'water_electric' => '水电费',
            'heating_costs' => '暖气费',
            'house_rent' => '房租',
            'income_tax' => '个人所得税',
            'wage_garnishment' => '扣发工资',
            'wage_actual' => '实发工资'
        );
        $regex_month = [
            'required',
            'regex:/^([1-9]|1[0-2])$/'
        ];
        $regex_wage = [
            'regex:/^([1-9]\d{0,9}|0)([.]?|(\.\d{1,2})?)$/'
        ];
        $rules = array(
            'wage_year' => 'required|regex:/^(20\d{2})$/',
            'wage_month' => $regex_month,
            'wage_base' => $regex_wage,
            'wage_allowance' => $regex_wage,
            'wage_bonus' => $regex_wage,
            'wage_should' => $regex_wage,
            'water_electric' => $regex_wage,
            'heating_costs' => $regex_wage,
            'house_rent' => $regex_wage,
            'income_tax' => $regex_wage,
            'wage_garnishment' => $regex_wage,
            'wage_actual' => $regex_wage
        );

        $validator = Validator::make($wage, $rules, $message, $attributes);
        $validate_result = $validator->errors()->all();
        $validate_count = count($validate_result);
        if (!empty($validate_count)) {
            foreach ($validate_result as $value) {
                $validate_info .= $value . " ";
            }
        }
        return $validate_info;
    }

    /**
     * 获取当前用户所用工资
     */
    public static function gets()
    {
        // 获取登录用户信息
        $user = DB::table('users')->where('id', get_session_user_id())->first();

        $wages = self::where('code', $user->code)->where('status', '0')->get();
        return $wages;
    }
}
