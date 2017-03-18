<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>IP控制网关</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href=/css/mobile.css rel=stylesheet>
  </head>
  <body>
    <div id="mobile">
        <div class="weui-cells__title">IP控制网关</div>
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label for="" class="weui-label">用户名</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" name="username" v-model="username">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label for="" class="weui-label">密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" name="password" v-model="password">
                </div>
            </div>
            <div class="weui-btn-area">
                <button type="submit" class="weui-btn weui-btn_primary">登录</button>
            </div>
        </div>
    </div>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script type=text/javascript src=/js/mobile.js></script>
  </body>
</html>
