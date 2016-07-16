<template>
<section class="content">
  <h1>Categories</h1>
  <button type="button" @click="createCategory" class="btn btn-lg btn-primary btn-flat" style="margin-bottom: 15px;">Add new category</button>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">All Categories</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tr>
              <th>Category Name</th>
              <th>Icon</th>
            </tr>
            <tr v-for="category in categories">
              <td>
                {{category.name}}
              </td>
              <td>{{category.icon}}</td>
              <td class="col-sm-3">
                <div class="btn-group">
                    <button type="button" v-link="{ name: 'postincats', params: {hashid: category.hashid}}" class="btn btn-success">
                      View posts
                    </button>
                    <button type="button" v-link="{ name: 'categories', params: {hashid: category.hashid}}" class="btn btn-warning">
                      Edit
                    </button>
                    <button class="btn btn-danger" @click="deleteCategory(category)">Delete</button>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
</template>

<script>
import { stack_bottomright, show_stack_success, show_stack_error, show_stack_info } from '../Pnotice.js'

export default {
  ready () {
    this.fetchCategories()
  },
  data () {
    return {
      categories: {}
    }
  },
  methods: {
    fetchCategories () {
      this.$http({url: '/api/categories/', method: 'GET'}).then(function (response) {
        this.$set('categories', response.data.data)
      })
    },
    createCategory () {
      this.$http({url: '/api/categories', method: 'POST'}).then(function (response) {
        show_stack_info('Creating Category...', response)
        this.$router.go('/categories/'  + response.data.hashid + '/edit')
      })
    },
    deleteCategory (category) {
      let self = this
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this category!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it',
      }).then(function() {
        self.categories.$remove(category)
        self.$http.delete('/api/categories/' + category.hashid, category).then(function (response) {
          swal(
            'Deleted!',
            'Your category has been deleted.',
            'success'
          );
        }, function (response){
          show_stack_error('Failed to delete category', response)
        })
      }, function(dismiss) {
        // dismiss can be 'cancel', 'overlay', 'close', 'timer'
        if (dismiss === 'cancel') {
          swal(
            'Cancelled',
            'Your category is safe :)',
            'error'
          );
        }
      });
    },
  }
}
</script>
