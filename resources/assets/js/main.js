import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'


Vue.use(VueRouter)

Vue.use(VueResource)

/* eslint-disable no-new */

const routes = [
  {
    path: '/',
    name: 'home',
    component: require('./components/Home.vue')
  },
  {
    path: '/posts/',
    name: 'posts',
    component: require('./components/Posts.vue')
  },
  {
    path: '/posts/categories/:hashid',
    name: 'postincats',
    component: require('./components/Posts.vue')
  },
  {
    path: '/posts/:hashid/edit',
    alias:'/posts/:hashid',
    name: 'editpost',
    component: require('./components/Editpost.vue')
  },
  {
    path: '/users',
    name: 'users',
    component: require('./components/Users.vue')
  },
  {
    path: '/categories',
    component: require('./components/Categories.vue')
  },
  {
    path: '/categories/:hashid/edit',
    alias: 'categories/:hashid',
    name: 'categories',
    component: require('./components/Editcategory.vue')
  },
  {
    path: '/profile',
    component: require('./components/Profile.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: 'dashboard',
  routes
})

new Vue(Vue.util.extend({ router }, App)).$mount('#app');
// const app = new Vue({
//   // el: '#app',
//   router,
//   // render: h => h(App)
//   // template: `<app>HI</app>`
// }).$mount('#app')
