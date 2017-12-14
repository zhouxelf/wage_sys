<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /*
     * 修改密码
     */
    public function updatePwd(Request $request)
    {
        $old_pwd = $request->old_pwd;
        $new_pwd = $request->new_pwd;
        $re_pwd = $request->re_pwd;

        if (strlen($new_pwd) < 5 || strlen($new_pwd) > 20) {
            return response()->json(['status' => 1, 'msg' => '新密码长度为5~20位']);
        }

        if ($new_pwd != $re_pwd) {
            return response()->json(['status' => 1, 'msg' => '两次输入新密码不一致']);
        }

        if (!User::isPwdRight($old_pwd)) {
            return response()->json(['status' => 1, 'msg' => '原密码不正确']);
        }

        if (User::updatePwd($new_pwd)) {
            return response()->json(['status' => 0, 'msg' => '密码修改成功']);
        } else {
            return response()->json(['status' => 1, 'msg' => '密码修改失败,请重试']);
        }
    }

    /*
     * 获取用户列表
     */
    public function getList(Request $request)
    {
        $pageSize = $request->pageSize;
        $keyword = $request->keyword;
        $users = User::getList($pageSize, $keyword);
        if (!empty($users)) {
            return $users;
        } else {
            return responseToJson(1, '用户加载失败');
        }
    }

    /*
     * 获取单个用户，用于编辑
     */
    public function get(Request $request)
    {
        $id = $request->id;
        $res = User::find($id);

        if ($res) {
            return responseToJson(0, 'success', $res);
        } else {
            return responseToJson(1, '信息加载失败');
        }
    }

    /*
     * 获取用户名
     */
    public function getUserName(Request $request)
    {
        $code = $request->code;
        $res = User::where('code', $code)->where('status', '0')->where('type', 0)->first();

        if ($res) {
            return responseToJson(0, 'success', $res->name);
        } else {
            return responseToJson(1, '用户不存在');
        }
    }

    /*
     * 添加、编辑用户
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $code = $request->code;
        $name = $request->name;
        $sex = $request->sex;
        $phone = $request->phone;

        if (!$code) {
            return responseToJson(1, '工号不能为空');
        }

        if (!$name) {
            return responseToJson(1, '姓名不能为空');
        }

        if (!is_phone($phone)) {
            return responseToJson(1, '手机号格式错误');
        }
        $user = [
            'id' => $id,
            'code' => $code,
            'name' => $name,
            'sex' => $sex,
            'phone' => $phone
        ];
        $res = User::edit($user);
        if ($res) {
            return responseToJson(0, '保存成功');
        } else {
            return responseToJson(1, '保存失败，请重试');
        }

    }

    /*
     * 删除用户
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        $res = User::del($id);
        if ($res) {
            return responseToJson(0, '删除成功');
        } else {
            return responseToJson(1, '删除失败，请重试');
        }
    }

    /**
     * 导入用户
     * @param Request $request
     */
    public function import(Request $request)
    {
        return User::import($request);
    }

    /*
     * 下载模板
     */
    public function template()
    {
        Excel::create("用户模板", function ($excel) {
            $excel->sheet("用户模板", function ($sheet){
                $data = [
                    ['工号', '姓名', '性别', '手机号'],
                ];
                $sheet->rows($data);
                $sheet->setWidth(array(
                    'A' => 15,
                    'B' => 15,
                    'C' => 15,
                    'D' => 15,
                ));
            });
        })->export("xls");
    }
}
