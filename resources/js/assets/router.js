window.Vue = require('vue');
import VueRouter from 'vue-router';
import PostList from '../components/PostListComponent.vue';
import PostDetails from '../components/PostDetailsComponent.vue';
import PostCategory from '../components/PostCategoryComponent.vue';
import CategoryListDefault from '../components/CategoryListDefaultComponent.vue';

import Contact from '../components/ContactComponent.vue';


// 0. If using a module system (e.g. via vue-cli), import Vue and VueRouter
// and then call `Vue.use(VueRouter)`.

// 1. Define route components.
// These can be imported from other files
//* */

Vue.use(VueRouter);

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [
    { path: '/', component: PostList, name: "list" },
    { path: '/detail/:id', component: PostDetails, name: "detail" },
    { path: '/post-category/:category_id', component: PostCategory, name: "post-category" },
    { path: '/contact', component: Contact, name: "contact" },
    { path: '/categories', component: CategoryListDefault, name: "list-category" },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
export default new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});