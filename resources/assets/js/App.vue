<template>
  <div id="app">
    <div class="navigation">
      <navbar></navbar>
      <sidebar></sidebar>
    </div>
    <div>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Admin Panel
            <small>Everything is here.</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Your Page Content Here -->
          <!-- route outlet -->
          <router-view></router-view>
        </section>
        <!-- /.content -->
      </div>
    </div>
  </div>
</template>


<script>
import Navbar from './components/layouts/Navbar.vue'
import Sidebar from './components/layouts/Sidebar.vue'



export default {
  name: 'app',
  components: {
    Navbar,
    Sidebar
  }
}
</script>
