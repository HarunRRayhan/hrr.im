require('./bootstrap');

import Vue from 'vue';
import {InertiaApp} from '@inertiajs/inertia-vue';
import VueMeta from 'vue-meta';
import {InertiaForm} from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import {InertiaProgress} from '@inertiajs/progress';
import './Mixins/filters';

Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueMeta);
Vue.mixin({methods: {route: window.route}})

InertiaProgress.init({
    // The color of the progress bar.
    color: '#29d',

    // Whether to include the default NProgress styles.
    includeCSS: true,
});

const app = document.getElementById('app');
const appName = process.env.MIX_APP_NAME;

new Vue({
    metaInfo: {
        titleTemplate: (title) => title ? `${title} - ${appName}` : appName
    },
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
