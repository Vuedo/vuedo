<template>
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-list"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Posts</span>
          <span class="info-box-number">{{posts.length}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-orange"><i class="fa fa-th-large"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Categories</span>
          <span class="info-box-number">{{categories.length}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-purple"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Users</span>
          <span class="info-box-number">3</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-primary">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  ready () {
   this.fetchPosts()
   this.fetchCategories()
  },
  data () {
    return {
      posts: [],
      categories:[],
    }
  },
  methods: {
    fetchPosts () {
      this.$http({url: '/api/posts', method: 'GET'}).then(function (response) {
        this.$set('posts', response.data.data)
      })
    },
    fetchCategories() {
      this.$http({url: '/api/categories', method: 'GET'}).then(function (response) {
        this.$set('categories', response.data.data)
      })
    },
  }
}
</script>
