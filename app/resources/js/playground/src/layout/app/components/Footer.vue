<template>
    <q-footer reveal class="bg-teal-1 text-primary">
        <p class="text-right q-mt-none q-mb-none q-mr-sm text-caption">
            App: <span class="text-bold">v. {{ appVersion }}</span> &nbsp; &nbsp;
            API: <span class="text-bold">v. {{ apiVersion }}</span>
        </p>
    </q-footer>
</template>
<script type="ts">
import { defineComponent } from 'vue'
import config from '@/config'

export default defineComponent({
    name: "Footer",
    setup() {
        return {
            apiVersion: config.API_VERSION,
            appVersion: config.APP_VERSION,
        }
    },
})
</script>
