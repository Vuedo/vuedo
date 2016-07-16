<template>
  <header class="main-header">
    <!-- Logo -->
    <a @click="goHome" href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>V</b>UE</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Vue.js</b> News</span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img class="profile-user-img img-responsive img-circle user-image"
              :src="user.avatar" alt="User profile picture">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{user.name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img class="profile-user-img img-responsive img-circle"
                :src="user.avatar" alt="User profile picture">

                <p>
                  {{user.name}}
                  <small>{{user.username}}</small>
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a v-link="{ path: '/profile' }" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat" @click="logout">Log out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>

export default {
  created() {
    this.fetchUser()
  },
  data () {
    return {
      user: {}
    }
  },
  methods: {
    fetchUser () {
      this.$http({url: '/api/me', method: 'GET'}).then(function (response) {
        this.$set('user', response.data)
      })
    },
    logout () {
      this.$http({url: 'logout', method: 'GET'}).then(function (response) {
        window.location.assign('/logout')
      })
    },
    goHome () {
      window.location.assign('/')
    }
  }
}
</script>
