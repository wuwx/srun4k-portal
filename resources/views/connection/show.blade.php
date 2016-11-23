<div id="new_connection">
    {{ $connection->user_ip }}
    {{ $connection->user_name }}

    <a href="/connection" class="btn btn-default" data-method="DELETE" data-remote="true" data-disable-with="正在断开..." data-params='{"action": "2"}'>断开连接</a>
</div>
