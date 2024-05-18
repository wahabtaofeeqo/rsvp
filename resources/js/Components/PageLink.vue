<template>
    <div v-if="links.length == 3"></div>
    <div v-else className="flex flex-wrap mt-6 -mb-1">
        <div v-for="link in links">
            <Link v-if="link.url" :className=getClasses(link) :href=link.url>
                <span v-html="link.label"></span>
            </Link>
            <div v-else :className=getClasses(link) v-html="link.label"></div>
        </div>
    </div>

</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import classNames from 'classnames';

defineProps<{
    links: any[],
    active?: boolean
}>()

const getClasses = ({active, url}: any) => {
    return url == null ? 
    classNames(
        'mr-1 mb-1 px-4 py-3 text-sm border rounded border-solid border-gray-300 text-gray'
    ) : 
    classNames(
        [
            'mr-1 mb-1',
            'px-4 py-3',
            'border border-solid border-gray-300 rounded',
            'text-sm',
            'hover:bg-white',
            'focus:outline-none focus:border-indigo-700 focus:text-indigo-700'
        ],
        {
            'bg-white': active
        }
    );
}

</script>