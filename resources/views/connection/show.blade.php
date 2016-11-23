<div id="new_connection">
    {{ $connection["user_name"] }}
    {{ $connection["bytes_in"] }}
    <a href="/connection" class="btn btn-default" data-method="DELETE" data-remote="true" data-disable-with="正在断开..." data-params='{"action": "2"}'>断开连接</a>
</div>
