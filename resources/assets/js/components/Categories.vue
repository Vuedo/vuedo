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
        <div class="box-body table-responsive">
          <table class="table table-striped">
            <tr>
              <th class="col-xs-2 col-md-3 col-lg-4">Category Name</th>
              <th class="col-xs-2 col-md-3 col-lg-4">Icon</th>
              <th class="col-xs-8 col-md-6 col-lg-4">Actions</th>
            </tr>
            <tr v-for="category in categories">
              <td class="col-xs-2 col-md-3 col-lg-4">
                {{category.name}}
              </td>
              <td class="col-xs-2 col-md-3 col-lg-4">{{category.icon}}</td>
              <td class="col-xs-8 col-md-6 col-lg-4">
                <div class="btn-group">
                  <router-link :to="{ name: 'postincats', params: { hashid: category.hashid }}" tag="button" class="btn btn-success">
                    View posts
                  </router-link>
                  <router-link :to="{ name: 'categories', params: { hashid: category.hashid }}" tag="button" class="btn btn-warning">
                    Edit
                  </router-link>
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
import Vue from 'vue'
import { stack_bottomright, show_stack_success, show_stack_error, show_stack_info } from '../Pnotice.js'

export default {
  name: 'CategList',
  mounted () {
    this.fetchCategories()
  },
  data () {
    return {
      categories: {}
    }
  },
  methods: {
    fetchCategories () {
      axios.get('/api/categories/').then(response => {
        Vue.set(this, 'categories', response.data.data)
      })
    },
    createCategory () {
      axios.post('/api/categories').then(response => {
        show_stack_info('Creating Category...', response)
        this.$router.push('/categories/'  + response.data.hashid + '/edit')
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
        // self.categories.$remove(category)
        var index = self.categories.indexOf(category); self.categories.splice(index, 1)
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
