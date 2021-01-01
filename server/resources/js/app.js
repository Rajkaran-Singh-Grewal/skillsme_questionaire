require('./bootstrap');
const routes = [
    { path: '/dashboard', component: require('../components/DashboardComponent')},
    { path: '/questionnaire', component: require('../components/QuestionnaireComponent')},
    { path: '/response', component: require('../components/ResponseComponent')},
];
const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes,
});
const app = Vue.createApp({});
app.component('AppComponent',require('../components/AppComponent'));
app.use(router);
app.mount('#app');
