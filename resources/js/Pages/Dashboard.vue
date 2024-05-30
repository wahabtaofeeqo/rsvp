<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12 px-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-end mb-4">
                    <Link href="/send-qr">Send QR</Link>
                </div>

                <div v-if="!pagination.data?.length">
                    <p class="text-center">No body has RSVPed yet</p>
                </div>

                <div v-if="$page.props.flash.message" class="alert mb-4 font-bold">
                    {{ $page.props.flash.message }}
                  </div>

                <div v-else className="relative overflow-x-auto">
                    <table className="w-full text-sm text-left text-gray-500">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" className="px-6 py-3">#</th>
                                <th scope="col" className="px-6 py-3">Name</th>
                                <th scope="col" className="px-6 py-3">Phone</th>
                                <th scope="col" className="px-6 py-3">Children</th>
                                <th scope="col" className="px-6 py-3">QR Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr className="bg-white border-b" v-for="(model, index) in pagination.data">
                                <td className="px-6 py-4">{{ index + 1 }}</td>
                                <td scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{model.name}}
                                </td>
                                <td className="px-6 py-4"> {{model.phone}} </td>
                                <td className="px-6 py-4"> {{model.children}} </td>
                                <td className="px-6 py-4"> {{parseInt(model.is_sent) ? 'Sent' : 'Not Sent'}} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div className='px-6 py-3'>
                    <PageLink :links="pagination?.links"></PageLink>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script setup lang="ts">

// defineProps<{
//     models: any;
//     status?: string;
// }>();

import PageLink from '@/Components/PageLink.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const $page: any = usePage();
const pagination: any = computed(() => $page.props.models || []);

</script>