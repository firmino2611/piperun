import Vue from 'vue'
import Router from 'vue-router'
import Home from "../views/home/Home";
import Login from "../views/auth/Login";
import Tasks from "../views/tasks/Tasks";
import Types from "../views/types/Types";

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [{
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/atividades',
            name: 'Tasks',
            component: Tasks
        },
        {
            path: '/tipos',
            name: 'Types',
            component: Types
        }
    ]
})