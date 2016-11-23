<form id="new_connection" action="/connection" class="form-horizontal" method="post" data-remote="true">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="action" value="login">
    <input type="hidden" name="ac_id" value="1">
    <input type="hidden" name="user_ip" value="">
    <input type="hidden" name="nas_ip" value="">
    <input type="hidden" name="user_mac" value="">
    <input type="hidden" name="url" value="" >

    <p></p>
    <div class="form-group">
      <label class="col-sm-3 control-label" for="username">用户名(Username):</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="user_name" size=35 />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label" for="password">密&nbsp;&nbsp;码(Password):</label>
      <div class="col-sm-5">
        <input class="form-control" type="password" name="user_password" size=35 />
      </div>
    </div>

    <input name="save_me" title="记忆密码" type="hidden" value="0"  />
    <!--
    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-10">
        <div class="checkbox">
          <label>
            <input name="save_me" title="记忆密码" type="checkbox" value="1"  /> 记住密码
          </label>
        </div>
      </div>
    </div>
    -->
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="连接网络(Connect)" class="btn btn-primary" data-disable-with="正在连接...">
        <a href="/connection" class="btn btn-default" data-method="DELETE" data-remote="true" data-disable-with="正在断开..." data-params='{"action": "2"}'>断开网络(Disconnect)</a>
        <a href="/connection" class="btn btn-default" data-method="DELETE" data-remote="true" data-disable-with="正在断开..." data-params='{"action": "3"}'>断开全部连接(Disconnect All)</a>
      </div>
    </div>
</form>
