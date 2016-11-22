<template>
    <div class="panel panel-default">
        <div class="panel-heading">网络中心黑板报</div>
        <div class="panel-body">
            <ul>
                <li v-for="post in posts">
                    <a target="_blank" :href="post.url">[{{ post.date }}] {{ post.title }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            this.$http.get('/post')
                .then(function(response) {
                    this.posts = response.data.posts.slice(0, 7);
                    this.posts.forEach(function(post){
                        post.title = post.title.substr(0, 29);
                        post.date  = post.date.substr(0, post.date.indexOf(" "));
                    });
                });
            return {
                posts: []
            };
        }
    }
</script>
