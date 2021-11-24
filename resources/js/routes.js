const Home = ()=> import('./components/Home.vue');
const Sale = ()=> import('./components/Sales.vue'); 

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'sale',
        path: '/sale',
        component: Sale
    },

];