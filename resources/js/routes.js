// import Vue from 'vue'
// import Router from 'vue-router'
// Vue.use(Router)

import MainApp from './components/MainApp';
import DashBoard from './components/pages/DashBoard';
import AccountList from './components/pages/AccountList';
import DomainList from './components/pages/DomainList';
import SiteList from './components/pages/SiteList';
import GetAccount from './components/pages/GetAccount';

export default {
    mode : 'history',
    routes : [
        {
            path: '/home',
            component: MainApp
        },
        {
            path: '/DashBoard',
            component: DashBoard
        },
        {
            path: '/AccountList',
            component: AccountList
        },
        {
            path: '/DomainList',
            component: DomainList
        },
        {
            path: '/SiteList',
            component: SiteList
        },
        {
            path: '/GetAccount',
            component: GetAccount
        },

    ]
};
