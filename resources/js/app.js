require('./bootstrap');

import Vue from 'vue';
import {InertiaApp} from '@inertiajs/inertia-vue';
import VueMeta from 'vue-meta';
import {InertiaForm} from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import { InertiaProgress } from '@inertiajs/progress/src';

Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueMeta);

InertiaProgress.init();

const app = document.getElementById('app');

new Vue({
    metaInfo: {
        titleTemplate: (title) => title ? `${title} - HRR.IM` : 'HRR.IM'
    },
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
