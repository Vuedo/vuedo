<template>
<section class="content">
  <h1 v-if="this.categoryId = this.$route.params.hashid">Posts in {{singleCategory}}</h1>
  <h1 v-else>Posts</h1>
  <button type="button" @click="createPost" class="btn btn-lg btn-primary btn-flat" style="margin-bottom: 15px;">
    Create Post
  </button>
  <button type="button" @click="refresh" class="btn pull-right btn-lg btn-warning btn-flat" style="margin-bottom: 15px;">
    Refresh page
  </button>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">All posts</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Image</th>
              <th>Categories</th>
              <th>Actions</th>
              <th>Status</th>
            </tr>
            <tr v-for="post in posts">
              <td>{{post.hashid}}</td>
              <td class="col-md-3">{{post.title}}</td>
              <td class="col-md-3">{{post.description}}</td>
              <td class="col-md-2">
                <div class="box-body">
                  <img class="img-responsive img-thumbnail" :src="post.image || 'https://i.imgur.com/F12Dfl0.jpg'" alt="Photo">
                </div>
              </td>
              <td class="col-md-1">
                <div v-if="post.categories === undefined">
                  <b class="badge bg-aqua">{{singleCategory}}</b>
                </div>
                <div v-else>
                  <div v-for="category in post.categories.data">
                   <b class="badge bg-aqua">{{category.name}}</b>
                 </div>
                </div>
              </td>
              <td class="col-md-3">
                <div class="btn-group">
                  <a v-if="post.status == 'approved'" href="/blog/{{post.slug}}" target="blank"  class="btn btn-success" role="button">View</a>
                  <button v-link="{ name: 'editpost', params: {hashid: post.hashid}}" type="button" class="btn btn-info">Edit</button>
                  <button type="button" class="btn btn-danger" @click="deletePost(post)">Delete</button>
                </div>
              </td>
              <td>
                <b v-if="post.status == 'approved'" class="label label-success">{{post.status}}</b>
                <b v-if="post.status == 'postponed'" class="label label-info">{{post.status}}</b>
                <b v-if="post.status == 'pending'" class="label label-warning">{{post.status}}</b>
                <b v-if="post.status == 'rejected'" class="label label-danger">{{post.status}}</b>
              </td>
            </tr>
          </table>
          <div>
            <v-paginator :resource.sync="posts" :resource_url="resource_url" :options="options"></v-paginator>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
</template>

<script>
import VuePaginator from 'vuejs-paginator/dist/vuejs-paginator.min.js'
import Multiselect from 'vue-multiselect/lib/vue-multiselect.js'
import { stack_bottomright, show_stack_success, show_stack_error, show_stack_info } from '../Pnotice.js'

export default {
  components: {
    VPaginator: VuePaginator,
    Multiselect
  },
  created () {
    this.categoryId = this.$route.params.hashid
  },
  ready () {
   this.fetchCategories()
  },
  data () {
    return {
      options: {
        remote_data: 'data',
        remote_current_page: 'meta.pagination.current_page',
        remote_last_page: 'meta.pagination.total_pages',
        remote_next_page_url: 'meta.pagination.links.next',
        remote_prev_page_url: 'meta.pagination.links.previous'
      },
      posts: [],
      options2: [],
      categoryId: '',
    }
  },
  methods: {
    fetchCategories () {
      this.$http({url: '/api/categories', method: 'GET'}).then(function (response) {
        this.$set('options2', response.data.data)
      })
    },
    deletePost (post) {
      let self = this
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this post!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it',
      }).then(function() {
        self.posts.$remove(post)
        self.$http.delete('/api/posts/' + post.hashid, post).then(function (response) {
          swal(
            'Deleted!',
            'Your post has been deleted.',
            'success'
          );
        }, function (response){
          show_stack_error('Deletion of post went wrong.', response)
        })
      }, function(dismiss) {
        // dismiss can be 'cancel', 'overlay', 'close', 'timer'
        if (dismiss === 'cancel') {
          swal(
            'Cancelled',
            'Your post is safe :)',
            'error'
          );
        }
      });
    },
    createPost () {
      this.$http({url: '/api/posts', method: 'POST'}).then(function (response) {
        show_stack_info('Created', response)
        this.$router.go('/posts/'  + response.data.hashid + '/edit')
      })
    },
    refresh () {
      location.reload();
    }
  },
  computed: {
    resource_url: function () {
        if (this.$route.path == '/posts/categories/' + this.categoryId) {
          return '/api/categories/' + this.categoryId + '/posts'
        } else {
          return '/api/posts?include=categories'
        }
    },
    singleCategory: function () {
      for (var i = 0; i < this.options2.length; i++) {
         if (this.options2[i].hashid === this.categoryId) {
          return this.options2[i].name
        }
      }
    }
  },
}
</script>
