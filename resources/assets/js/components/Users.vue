<template>
<h1>Users</h1>
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Posts</th>
                  <th>Admin</th>
                </tr>
                <tr v-for="user in users">
                  <td>{{user.first}}</td>
                  <td>{{user.last}}</td>
                  <td>{{user.posts}}</td>
                  <td><span class="label label-success">{{user.admin}}</span></td>
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
  export default {
    data () {
      return {
      // note: changing this line won't causes changes
      // with hot-reload because the reloaded component
      // preserves its current state and we are modifying
      // its initial state.
      users: [
      {
        first: 'George',
        last: 'Mania',
        posts: 28,
        admin: true
      },
      {
        first: 'Gus',
        last: 'Mr. Weebl',
        posts: 8,
        admin: false
      },
      {
        first: 'Sunday',
        last: 'Darth Vader',
        posts: 52,
        admin: false
      },
      {
        first: 'Ika',
        last: 'Boromir',
        posts: 74,
        admin: false
      }
      ]
    }
  }
}
</script>

<style>
  body {
    font-family: Helvetica, sans-serif;
  }
</style>
