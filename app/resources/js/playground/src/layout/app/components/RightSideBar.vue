<template>
    <q-drawer
        v-model="isOpen"
        side="right"
        width=200
        show-if-above  
        bordered
    >
        <div class="text-center text-caption text-blue-grey-13">{{ t('common.doNotTestHere') }}</div>
        <q-separator />
    </q-drawer>
</template>

<script lang="ts">
import { 
    defineComponent,
    toRef
} from 'vue'

import { useI18n } from "vue-i18n";

export default defineComponent({
    name: "RightSideBar",
    props: {
        isOpened: Boolean,
    },
    setup(props) {
        let isOpen = toRef(props, 'isOpened');
        const { t } = useI18n();

        return {
            isOpen,
            t
        }
    }
});
</script>