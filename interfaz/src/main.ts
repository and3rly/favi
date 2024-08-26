import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { Vue3ProgressPlugin } from '@marcoschulte/vue3-progress';
import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar';
import mitt from 'mitt';
import 'vue3-perfect-scrollbar/style.css';
import '@marcoschulte/vue3-progress/dist/index.css';
import '@fortawesome/fontawesome-free/scss/fontawesome.scss';
import '@fortawesome/fontawesome-free/scss/regular.scss';
import '@fortawesome/fontawesome-free/scss/solid.scss';
import '@fortawesome/fontawesome-free/scss/brands.scss';
import '@fortawesome/fontawesome-free/scss/v4-shims.scss';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap';
import './scss/styles.scss';

import App from './App.vue';
import router from './router';
import axiosClient from "@/plugins/axios.ts"

import Card from '@/components/bootstrap/Card.vue';
import CardBody from '@/components/bootstrap/CardBody.vue';
import CardHeader from '@/components/bootstrap/CardHeader.vue';
import CardFooter from '@/components/bootstrap/CardFooter.vue';
import CardGroup from '@/components/bootstrap/CardGroup.vue';
import CardImgOverlay from '@/components/bootstrap/CardImgOverlay.vue';
import CardExpandToggler from '@/components/bootstrap/CardExpandToggler.vue';
import quillEditor from '@/components/plugins/QuillEditor.vue';
import vueSelect from '@/components/plugins/VueSelect.vue';

import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import { Modal } from 'bootstrap'
import { PiniaSharedState } from 'pinia-shared-state';

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import { useToast } from "vue-toastification";

const emitter = mitt();
const toast = useToast();
const app = createApp(App);

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
pinia.use(
  PiniaSharedState({
    enable: true,
    initialize: false,
    type: 'localstorage',
  }),
);

app.component('Card', Card);
app.component('CardBody', CardBody);
app.component('CardHeader', CardHeader);
app.component('CardFooter', CardFooter);
app.component('CardGroup', CardGroup);
app.component('CardImgOverlay', CardImgOverlay);
app.component('CardExpandToggler', CardExpandToggler);
app.component('QuillEditor', quillEditor);
app.component('vueSelect', vueSelect);

app.use(Toast, {
  transition: "Vue-Toastification__fade",
  filterBeforeCreate: (toast, toasts) => {
    if (toasts.filter(
      t => t.type === toast.type
    ).length !== 0) {
      return false;
    }
    return toast;
  }
})  

let url = 'index.php';
let piniaUrlBase = (context: PiniaPluginContext) => {
  return {
    urlBase: url
  };
};

pinia.use(piniaUrlBase);
app.use(pinia);
app.use(router);
app.use(Vue3ProgressPlugin);
app.use(PerfectScrollbarPlugin);

let urlImp = import.meta.env.VITE_API_BASE_URL

app.config.globalProperties.emitter = emitter
app.config.globalProperties.$http = axiosClient
app.config.globalProperties.$modal = Modal
app.config.globalProperties.$toast = toast
app.config.globalProperties.$baseUrl = url
app.config.globalProperties.$urlImp = urlImp+"index.php"

app.mount('#app');
