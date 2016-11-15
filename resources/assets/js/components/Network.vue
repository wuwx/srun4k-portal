<template>
    <div class="panel panel-default">
        <div class="panel-heading">网络中心黑板报</div>
        <div class="panel-body">
            <a target="_blank" ng-href="post.url">[post.date] post.title</a>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component ready.')
        }
    }
</script>
