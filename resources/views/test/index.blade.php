<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QQ Login</title>
</head>
<body>
<a href="" onclick='toLogin()'>
    <img src="{{ asset('img/qq-logo.jpg') }}"></a>
</body>
<script>
    function toLogin()
    {
        //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
        //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
        var A=window.open("{!! $oauthUrl !!}","TencentLogin",
            "width=800,height=400,menubar=0,scrollbars=1,left=50,top=50",
        resizable=1,status=1,titlebar=0,toolbar=0,location=1);
    }
</script>
</html>
