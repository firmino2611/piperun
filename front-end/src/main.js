// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Root from './Root'
import router from './router'
import store from './store/index'
import VueToast from 'vue-toast-notification';
import Storage from 'local-storage-firmino'
// import VueRouter from 'vue-router'
import VueTheMask from 'vue-the-mask'
// Import any of available themes
import 'vue-toast-notification/dist/theme-sugar.css';
import Api from './services/Api'


import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

Vue.use(VueTheMask)

Vue.use(VueToast, {
    position: 'top-right'
});

Vue.$storage = Storage;
Vue.config.productionTip = false
    /* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    components: { Root },
    // template: '<Root/>',
    render: h => h(Root),
    async mounted() {
        let api = new Api()
        try {
            if (!Storage.exists('token-user'))
                this.$router.push('/login').catch()
            else {
                let resp = await api.request({
                    url: 'auth/me',
                    method: 'post',
                })
            }
        } catch (e) {
            this.$router.push('/login').catch()
            Storage.delete('token-user')
        }

    },
})