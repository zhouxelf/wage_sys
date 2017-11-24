<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>登陆页面-{{ config('app.name') }}</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            transition: border .5s;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .wrap {
            width: 800px;
            margin: 0 auto;
        }

        .header {
            color: #fff;
            font-size: 30px;
            padding: 100px 0 50px;
            text-align: center;
        }

        .point {
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: #fff;
            border-radius: 10px;
            line-height: 40px;
            vertical-align: middle;
        }

        .login-box-bg {
            position: absolute;
            background-color: #fbfdff;
            width: 100%;
            height: 100%;
            top: 0;
            right: 0;
            z-index: -1;
            opacity: 0.7;
        }

        .login-box {
            position: relative;
            width: 300px;
            border: 1px solid #eaf1f1;
            border-radius: 3px;
            padding: 15px 25px;
            margin: 0 auto;
            z-index: 1;
        }

        .login-form div {
            z-index: 100;
        }

        .login-input {
            margin-top: 20px;
            border: 1px solid #cdcdcd;
            border-radius: 3px;
            padding: 8px 10px;
            background-color: #F5FFFF;
        }

        .login-input input {
            width: 220px;
            height: 25px;
            padding: 0 15px;
            line-height: 20px;
            border: 0;
            outline: none;
            display: block;
            font-size: 14px;
        }

        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 15px #fbfdff inset;
        }

        input {
            background: rgba(0, 0, 0, 0);
        }

        #submit {
            margin: 25px 0;
            background-color: #3099e9;
            color: #fff;
            width: 300px;
            border: 0;
            border-radius: 3px;
            font-size: 18px;
            padding: 8px 0;
            cursor: pointer;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            text-align: center;
            color: #fff;
            width: 100%;
            font-weight: 300;
        }

        #tip {
            height: 10px;
            line-height: 15px;
            text-align: center;
            color: #F76260;
            font-size: 14px;
        }

        body, div, span, button, code, input, select, textarea {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", Arial, sans-serif;
        }
    </style>
</head>
<body style="width:100%;height:100%;">
    <div class="wrap">
        <div class="header">
            {{ config('app.copy_right') }} <span class="point"></span> {{ config('app.name') }}
        </div>
        <div class="content">
            <div class="login-box">
                <div class="login-box-bg"></div>
                <div id="tip"></div>
                <div class="login-form">
                    <div class="login-input">
                        <input type="text" name="name" id="name" placeholder="用户名" onkeydown="keyLogin(event)"/>
                    </div>
                    <div class="login-input">
                        <input type="password" name="pwd" id="pwd" placeholder='登录密码' onkeydown="keyLogin(event)"/>
                    </div>
                    <button id="submit">登 录</button>
                    <div style="clear:both;"></div>
                </div>
            </div>

            <div style="clear:both"></div>
        </div>
    </div>

    <div id="container" style="position: absolute;top: 0;z-index: -1;width: 100%;height: 100%;">
        <div id="anitOut"></div>
    </div>
    <div class="footer">
        {{ config('app.copy_right') }} Copyright ©2017 All Rights Reserved.
    </div>
    <script src="{{ url('/js/jquery.min.js') }}"></script>
    <script src="{{ url('/js/cav.js') }}"></script>
    <script>
        // 配置动态背景
        let victor = new Victor("container", "anitOut");
        // canvas背景主题设置
//        let theme = [
//            ["#002c4a", "#005584"],
//            ["#35ac03", "#3f4303"],
//            ["#ac0908", "#cd5726"],
//            ["#18bbff", "#00486b"]
//        ];

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#submit').click(function () {
            login();
        });
        //所有的input禁止输入空格
        $('input').on('input', function () {
            $(this).val($(this).val().replace(/(^\s+)|(\s+$)/g, ""));
        });

        function login() {
            if (check()) {
                let data = {
                    name: $('#name').val(),
                    pwd: $('#pwd').val()
                };
                $.ajax({
                    url: '/login',
                    type: 'post',
                    data: data,
                    success: function (data) {
                        if (data.status === 0) {
                            location.replace('/' + location.hash);
                        } else {
                            flashTip(data.msg);
                        }
                    },
                    error: function () {
                        flashTip('网络错误，请稍后再试!');
                    }
                })
            }
        }
        //检查输入
        function check() {
            let nameObj = $('#name');
            if (nameObj.val().length === 0) {
                nameObj.focus();
                flashBorder(nameObj.parent('.login-input'));
                return false;
            }
            let pwdObj = $('#pwd');
            if (pwdObj.val().length === 0) {
                pwdObj.focus();
                flashBorder(pwdObj.parent('.login-input'));
                return false;
            }

            return true;
        }

        //出错时border闪动提示
        function flashBorder(obj) {
            obj.css('border', '1px solid #ff7575');
            setTimeout(function () {
                obj.css('border', '1px solid #cdcdcd')
            }, 1000);
        }

        //消息提示
        function flashTip(msg) {
            $('#tip').html(msg);
            setTimeout(function () {
                $('#tip').html('');
            }, 3500);
        }
        //确定键登录
        function keyLogin(event) {
            if (event.keyCode === 13) {
                login();
            }
        }
    </script>
</body>
</html>