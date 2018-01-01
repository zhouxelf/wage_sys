<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class User extends Model
{
    const TYPE_COMMON = 0;
    const TYPE_ADMIN = 1;

    /**
     * 获取用户
     * @param $loginName /登录名:工号或手机号
     * @return mixed
     */
    public static function getUser($loginName)
    {
        $user = self::where('code', $loginName)
                    ->orWhere('phone', $loginName)
                    ->first();
        return $user;
    }

    /**
     * 判断原密码是否正确
     * @param $pwd /原密码
     */
    public static function isPwdRight($pwd)
    {
        $user = self::where('id', get_session_user_id())->first();
        return $user->password == encrypt_password($pwd, $user->salt);
    }

    /**
     * 修改密码
     * @param $pwd /新密码
     */
    public static function updatePwd($pwd)
    {
        $salt = get_salt();
        $password = encrypt_password($pwd, $salt);
        $res = self::where('id', get_session_user_id())
            ->update(['password' => $password, 'salt' => $salt]);
        return $res;
    }

    /**
     * 添加、编辑用户
     * @param $user
     * @return bool
     */
    public static function edit($user)
    {
        $id = $user['id'];
        $code = $user['code'];
        $name = $user['name'];
        $sex = $user['sex'];
        $phone = $user['phone'];

        $res = self::find($id);
        if (empty($res)) {
            $_user = new self;
            $_user->code = $code;
            $_user->name = $name;
            $_user->name_quanpin = get_pinyin_all($name);
            $_user->name_jianpin = get_pinyin_simple($name);
            $_user->sex = $sex;
            $_user->phone = $phone;
            $_user->salt = get_salt();
            $_user->password = encrypt_password(substr($phone, -6), $_user->salt);
            $_user->type = 0;
            $_user->status = 0;
            $_user->creator = get_session_user_id();
            return $_user->save();
        } else {
            $res->code = $code;
            $res->name = $name;
            $res->name_quanpin = get_pinyin_all($name);
            $res->name_jianpin = get_pinyin_simple($name);
            $res->sex = $sex;
            $res->phone = $phone;
            $res->updater = get_session_user_id();
            return $res->save();
        }
    }

    /**
     * 删除用户
     * @param $id /用户
     * @return mixed
     */
    public static function del($id)
    {
        $user = self::find($id);
        $user->status = '1';
        return $user->save();
    }

    /**
     * @param $pageSize /每页显示数量
     * @param $keyword /关键字
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getList($pageSize, $keyword)
    {
        $query = self::where('status', '0')->where('type', 0);
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'like', $keyword . '%')
                    ->orWhere('name_quanpin', 'like', $keyword . '%')
                    ->orWhere('name_jianpin', 'like', $keyword . '%')
                    ->orWhere('code', 'like', $keyword . '%');
            });
        }
        $result = $query->paginate($pageSize);
        return responseToPage($result);
    }

    /**
     * 导入用户
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
            return responseToJson(1, '保存文件失败');
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
                $find_res = self::where('code', $result[$i][0])->where('status', '0')->where('type', 0)->first();
                $code = $result[$i][0] ? $result[$i][0] : '';
                $name = $result[$i][1] ? $result[$i][1] : '';
                $sex = $result[$i][2] ? $result[$i][2] : '';
                $phone = $result[$i][3] ? $result[$i][3] : '';

                $code = trim($code);
                $name = trim($name);
                $sex = trim($sex);
                $phone = trim($phone);

                $user = [
                    'id' => 0,
                    'code' => $code,
                    'name' => $name,
                    'sex' => $sex,
                    'phone' => $phone,
                ];
                if (!is_phone($phone)) {
                    $error++;
                    $user['reason'] = "手机号格式错误";
                    array_push($error_data, $user);
                } else if (!empty($find_res)) {
                    $error++;
                    $user['reason'] = "工号已存在";
                    array_push($error_data, $user);
                } else {
                    $validate_info = self::validate($user);
                    if (!empty($validate_info)) {
                        $error++;
                        $user_temp = $user;
                        $user_temp['reason'] = $validate_info;
                        array_push($error_data, $user_temp);
                    } else {
                        $res = self::edit($user);
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
     * 用户信息验证
     * @param $user /待验证用户信息
     * @return string 验证结果
     */
    public static function validate($user)
    {
        $validate_info = "";
        $message = array(
            'required' => ':attribute不能为空',
            'max' => ':attribute不符合要求',
            'min' => ':attribute不符合要求',
            'in' => ':attribute不符合要求'
        );
        $attributes = array(
            'name' => '姓名',
            'sex' => '性别',
            'phone' => '手机号',
        );
        $rules = array(
            'name' => 'required|min:2|max:4',
            'sex' => 'required|in:"男","女"',
            'phone' => 'required|max:11',
        );

        $validator = Validator::make($user, $rules, $message, $attributes);
        $validate_result = $validator->errors()->all();
        $validate_count = count($validate_result);
        if (!empty($validate_count)) {
            foreach ($validate_result as $value) {
                $validate_info .= $value . " ";
            }
        }
        return $validate_info;
    }
}
