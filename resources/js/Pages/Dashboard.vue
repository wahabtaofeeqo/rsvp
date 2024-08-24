<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12 px-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-end mb-6">
                    <button v-on:click="sendQr()">Send QR</button>
                    <a href="/export-qr" class="bg-sky-500 rounded ms-3 px-3 py-2 text-white">Export Data</a>
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
                                <!-- <th scope="col" className="px-6 py-3">Children</th> -->
                                <th scope="col" className="px-6 py-3">QR Status</th>
                                <th scope="col" className="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr className="bg-white border-b" v-for="(model, index) in pagination.data">
                                <td className="px-6 py-4">{{ index + 1 }}</td>
                                <td scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{model.name}}
                                </td>
                                <td className="px-6 py-4"> {{model.phone}} </td>
                                <!-- <td className="px-6 py-4"> {{model.children}} </td> -->
                                <td className="px-6 py-4"> {{parseInt(model.is_sent) ? 'Sent' : 'Not Sent'}} </td>
                                <td class="px-6 py-4">
                                    <!-- <Checkbox onchange="onChecked(model)" /> -->
                                     <input type="checkbox" 
                                        :checked="isChecked(model.id)" v-on:change="onChecked(model)">
                                    <!-- <Checkbox na v-model="model.checked"></Checkbox> -->
                                </td>
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

import Checkbox from '@/Components/Checkbox.vue';
import PageLink from '@/Components/PageLink.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const $page: any = usePage();
const selectedUsers: any = ref([]);
const pagination: any = computed(() => $page.props.models || []);

const isChecked = (id: any) => {
    return selectedUsers.value.findIndex((item: any) => item == id) != -1;
}

const onChecked = (model: any) => {
    let users: any[] = selectedUsers.value;
    let index = users.findIndex(item => item == model.id);
    if(index == -1) {
        if(users.length >= 5) {
            alert('Select only 5 persons at a time to send SMS to')
        }
        else selectedUsers.value.push(model.id);
    }
    else {
        selectedUsers.value.splice(index, 1);
    }
}

const sendQr = () => {
    let IDs: any[] = selectedUsers.value;
    if(IDs.length) {
        router.post(route('sendQR'), {ids: IDs}, {
            onSuccess: () => {
                selectedUsers.value = [];
            }
        })
    }
}

</script>