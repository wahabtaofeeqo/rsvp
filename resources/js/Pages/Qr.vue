<template>
    <Head title="MyQr" />
    <div class="h-screen" :class="'bg-cover'" >
        <div style="background-color: rgba(0, 0, 0, 0.5); height: 100%; width: 100%;" class="flex items-center justify-center">
            <div class="lg:w-1/4" style="height: 500px; overflow: hidden; position: relative;">
                <img src="/images/qr.jpeg" alt="Avatar" style="height: 100%; width: 100%;">
                <img :src="image" alt="qr" style="position: absolute; top: 45%; left: 0; right: 0; margin-right: auto; margin-left: auto;" width="100" height="100">
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const $page: any = usePage();
const model: any = computed(() => $page.props.qr);
const image: any = computed(() => {
    let model = $page.props.qr;
    return `/qrcode/${model?.code}.png`;
})
</script>