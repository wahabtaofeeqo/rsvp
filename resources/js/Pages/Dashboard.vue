<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aspernatur quidem optio, doloribus similique numquam harum enim placeat, aut rem aliquid repellat, possimus assumenda blanditiis fuga tenetur adipisci et vitae quasi.
            </div>
        </div>
    </AuthenticatedLayout>
</template>
