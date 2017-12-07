<?php

/**
 * 页面 Json 统一输出
 * @param int $code 0:成功,1:失败
 * @param string $msg
 * @param null $paras
 * @return \Illuminate\Http\JsonResponse
 */
function responseToJson($code = 0, $msg = '', $paras = null)
{
    $res["code"] = $code;
    $res["msg"] = $msg;
    $res["result"] = $paras;
    return response()->json($res);
}

function responseToPage($result)
{
    return response()->json($result);
}

function get_session_user()
{
    return session('user');
}

function get_session_user_id()
{
    $user = session('user');
    return $user ? $user->id : 0;
}

/**
 * 获取用户密码的加密字符串
 * @param $password
 * @param $salt
 * @return string
 */
function encrypt_password($password, $salt)
{
    return md5(md5($password) . $salt);
}

/**
 * 生成 UUID
 * @param string $prefix 可以指定前缀
 * @return string
 */
function create_uuid($prefix = "")
{
    $str = md5(uniqid(mt_rand(), true));
    $uuid = substr($str, 0, 8) . '-';
    $uuid .= substr($str, 8, 4) . '-';
    $uuid .= substr($str, 12, 4) . '-';
    $uuid .= substr($str, 16, 4) . '-';
    $uuid .= substr($str, 20, 12);
    return $prefix . $uuid;
}

function get_salt()
{
    $uuid = create_uuid();
    $salt = substr($uuid, strlen($uuid) - 4, 4);
    return $salt;
}

/**
 * 判断手机号是否合法
 * @param $phone
 * @return bool
 */
function is_phone($phone)
{
    $reg_phone = '/^1[3|5|7|8]\d{9}$/';
    if (preg_match($reg_phone, $phone)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 获取全拼
 * @param $str
 * @return mixed
 */
function get_pinyin_simple($str)
{
    return \Overtrue\LaravelPinyin\Facades\Pinyin::abbr($str);
}

/**
 * 获取简拼
 * @param $str
 * @return string
 */
function get_pinyin_all($str)
{
    $arr = \Overtrue\LaravelPinyin\Facades\Pinyin::convert($str);
    return implode("", $arr);
}