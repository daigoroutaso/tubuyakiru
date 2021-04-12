

<template>
    <a href="javascript:void(0)" @click="doCopy"><font-awesome-icon :icon="['far', 'copy']" size="2x" /></a>
</template>

<script>
import Vue from 'vue';
import VueClipboard from 'vue-clipboard2';
Vue.use(VueClipboard);

import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(fas,far)

Vue.component('font-awesome-icon', FontAwesomeIcon)

export default {

    methods: {
        doCopy: function () {
            this.$copyText(location.href).then(function (e) {

                toastr.options = {
                    "positionClass": "toast-top-full-width"
                }

                toastr.info('クリップボードにコピーしました（' + location.href + '）');
                console.log(e)
            }, function (e) {
                alert('Can not copy')
                console.log(e)
            })
        }
    }
}
</script>


