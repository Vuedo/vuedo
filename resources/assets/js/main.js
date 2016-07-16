import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'


Vue.use(VueRouter)

Vue.use(VueResource)

/* eslint-disable no-new */

var router = new VueRouter({
    history: true,
    root: 'dashboard'
})


router.map({
    '/': {
        component: require('./components/Home.vue')
    },
    '/posts/': {
        name: 'posts',
        component: require('./components/Posts.vue')
    },
    '/posts/categories/:hashid': {
        name: 'postincats',
        component: require('./components/Posts.vue')
    },
    '/posts/:hashid/edit': {
        name: 'editpost',
        component: require('./components/Editpost.vue')
    },
    '/users': {
        component: require('./components/Users.vue')
    },
    '/categories': {
        component: require('./components/Categories.vue')
    },
    '/categories/:hashid/edit': {
        name: 'categories',
        component: require('./components/Editcategory.vue')
    },
    '/profile': {
        component: require('./components/Profile.vue')
    },
})

router.alias({

    // alias can contain dynamic segments
    // the dynamic segment names must match
    '/posts/:hashid': '/posts/:hashid/edit',
    'categories/:hashid': '/categories/:hashid/edit'
})

router.start(App, 'body')
