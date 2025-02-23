// import { createApp, defineAsyncComponent } from 'vue';

import './bootstrap.js';

import "@fontsource/josefin-sans";
import './styles/app.css';

import { registerVueControllerComponents } from '@symfony/ux-vue';
registerVueControllerComponents(require.context('../../', true, /\.vue$/));


// Load components dynamically
// const componentFiles = require.context('../../', true, /^.*\.vue$/)
// const components = {}
// for (const file of componentFiles.keys()) {
//   const name = file.replace(/^\.\//, '').replace(/\.\w+$/, '').replace(/^.+\//, '')
//   components[name] = import(`../../${file.replace(/^\.\//, '')}`)
// }
// window.createApp = createApp;
// window.components = components;
