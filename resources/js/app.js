import './bootstrap';

import { createApp } from 'vue'
import router from './router.js';
import store from './store/index.js'

import app from './layouts/App.vue'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg'
import { mdiAccount, mdiAccountPlus, mdiAccountSupervisor, mdiChevronRight, mdiDownload, mdiEmail, mdiEye, mdiEyeOff, mdiHeart, mdiHome, mdiLock, mdiLogin, mdiLogout, mdiMoonFirstQuarter, mdiReload, mdiStar, mdiTrashCan, mdiViewDashboard, mdiWeatherNight } from '@mdi/js'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases: {
      ...aliases,
      account: mdiAccount,
      reload: mdiReload,
      home: mdiHome,
      star: mdiStar,
      login: mdiLogin,
      logout: mdiLogout,
      register: mdiAccountPlus,
      dashboard:mdiViewDashboard,
      email: mdiEmail,
      password: mdiLock,
      eye: mdiEye,
      eyeOff: mdiEyeOff,
      chevron_right: mdiChevronRight,
      heart: mdiHeart,
      trash: mdiTrashCan,
      users: mdiAccountSupervisor,
      moon: mdiWeatherNight,
      download: mdiDownload
    },
    sets: {
      mdi,
    },
  },
  theme: {
    defaultTheme: 'dark'
  }
})

createApp(app).use(vuetify).use(router).use(store).mount("#app")