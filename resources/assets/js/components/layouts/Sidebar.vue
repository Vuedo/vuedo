<template>
  <div>
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    {{creatingPost}}
      <!-- Sidebar user panel (optional) -->
      <router-link to="/profile" tag="div" class="user-panel">
        <div class="pull-left image">
          <img class="profile-user-img img-responsive img-circle"
          :src="user.avatar" alt="User profile picture">
        </div>
        <div class="pull-left info">
          <p>{{user.name}}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </router-link>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li><router-link :to="{ name: 'home'}"><i class="fa fa-home"></i> <span>Home</span></router-link></li>
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>Posts</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><router-link :to="{ name: 'posts'}"><i class="fa fa-tasks"></i>Index</router-link></li>
            <li><a @click="createPost" href="#"><i class="fa fa-keyboard-o"></i>Create post</a></li>
          </ul>
        </li>
        <li><router-link to="/categories"><i class="fa fa-th-large"></i> <span>Categories</span></router-link></li>
        <li><router-link to="/users"><i class="fa fa-users"></i> <span>Users</span></router-link></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="control-sidebar-bg"></div>
</div>
</template>

<script>
import { stack_bottomright, show_stack_success, show_stack_error, show_stack_info } from '../../Pnotice.js'
import Vue from 'vue'

export default {
  name: 'SideItem',
  created () {
    this.fetchUser()
  },
  data () {
    return {
      user: {}
    }
  },
  computed: {
    creatingPost: function () {
      return this.$route.name === 'editpost'
    }
  },
  methods: {
    fetchUser () {
      axios.get('/api/me').then(response =>{
        Vue.set(this, 'user', response.data)
      })
    },
    createPost () {
      if( !this.creatingPost ){
        axios.post('/api/posts').then(function (response) {
          show_stack_info('Creating post...', response)
          this.$router.push('/posts/'  + response.data.hashid + '/edit')
        }, function (response){
               show_stack_error('Failed to create post!', response)
             })
      } else {
        swal('Sorry', 'Please navigate elsewhere before creating new post.', 'info')
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1 {
  color: #42b983;
}
aside {
  height: 2100px;
}
.user-panel {
  cursor: pointer;
}
</style>
