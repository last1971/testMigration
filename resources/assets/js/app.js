
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//require('./user-edit');

window.Vue = require('vue');

var vueResource = require('vue-resource');
var vueBootstrap = require('bootstrap-vue');
var Vuex = require('vuex');
Vue.use(Vuex);
Vue.use(vueResource);
Vue.use(vueBootstrap);

const store = new Vuex.Store({
    state: {
        user: {user_type_id:3},
        routes: {articlestable:'articlestable'}
    },
    actions: {
        checkUser({commit}) {
            axios.get('current-user').then(response => {
                commit('setUser', response.data)
            })
        }
    },
    mutations: {
        setUser(state, user) {
            state.user = user
        }
    },
    getters: {
        user(state) {
            return state.user
        },
        routes(state) {
            return state.routes
        }
    }
})


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('userstable', require('./components/UsersTableComponent.vue'));
Vue.component('articles-table-component',require('./components/article/ArticlesTableComponent.vue'));
Vue.component('useredit', require('./components/UserEditComponent.vue'));
Vue.component('case-table-component', require('./components/case/CaseTableComponent.vue'));
Vue.component('producer-table-component', require('./components/producer/ProducerTableComponent.vue'));
Vue.component('product-table-component', require('./components/product/ProductTableComponent.vue'));
Vue.component('categories-tree-component', require('./components/category/CategoriesTreeComponent.vue'));
Vue.component('firm-table-component', require('./components/firm/FirmTableComponent.vue'));
var app = new Vue({
    store,
    el: '#app',

});
