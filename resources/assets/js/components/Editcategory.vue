<template>
  <!-- Horizontal Form -->
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Edit Category</h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form @keydown.enter.prevent="deleteCategory" class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label for="title" class="col-sm-1 control-label">Title</label>
        <div class="col-sm-11">
          <input type="text" class="form-control" id="title" placeholder="title" v-model="category.name">
        </div>
      </div>
      <div class="form-group">
        <label for="icon" class="col-sm-1 control-label">Icon</label>
        <div class="col-sm-11">
          <input class="form-control" id="icon" placeholder="fa fa-icon" v-model="category.icon">
        </div>
      </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <button class="btn btn-flat btn-info pull-right" @click="updateCategory(category)">Save category</button>
      <button class="btn btn-flat btn-danger" @click="deleteCategory(category)">Delete</button>
    </div>
    <!-- /.box-footer -->
  </form>
</div>
</template>

<script>
import { stack_bottomright, show_stack_success, show_stack_error } from '../Pnotice.js'

export default {
  ready(){
    this.fetchCategory()
  },
  data () {
    return {
      category: {}
    }
  },
  methods: {
    fetchCategory () {
      let itemId = this.$route.params.hashid
      this.$http({url: '/api/categories/' + itemId, method: 'GET'}).then(function (response) {
        this.$set('category', response.data)
      })
    },
    updateCategory (category) {
      event.preventDefault();
      this.$http.patch('/api/categories/' + category.hashid, category).then(function (response) {
        show_stack_success('Category saved', response)
      }, function (response){
        show_stack_error('Failed to save category', response)
      })
    },
    deleteCategory (category) {
      event.preventDefault();
      let self = this
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this category!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it',
      }).then(function() {
        self.$http.delete('/api/categories/' + category.hashid, category).then(function (response) {
          self.$router.go('/categories')
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
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1 {
  color: #42b983;
}
</style>
