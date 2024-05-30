<template>
    <Head title="Dashboard" />
    
    <AuthenticatedLayout>
        <Modal :show="showModal" v-on:close="toggleModal">
            <div class="p-4">
                <form @submit.prevent="submit">
                    <h4 class="mb-4 font-bold">Guest Details</h4>
                    <div class="mb-4">
                        <InputLabel for="family" value="Family" />

                        <TextInput
                            id="family"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.family"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.family" />
                    </div>

                    <div style="position: relative;">
                        <InputLabel for="phone" value="Phone" />
                        <select v-model="form.code" required style="outline: none; border: 0; position: absolute; top: 24px; background-color: transparent;">
                        <option value="234">NG</option>
                        <option value="1">US</option>
                        </select>
                        <TextInput
                            id="phone"
                            type="tel"
                            class="mt-1 block w-full pl-20"
                            v-model="form.phone"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>
                    <p class="text-sm mb-4 text-slate-500">Enter phone number without Country code and leading Zero</p>


                    <div class="mb-4">
                        <InputLabel for="children" value="Children" />

                        <TextInput
                            id="children"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.children"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.children" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="total" value="Total" />

                        <TextInput
                            id="total"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.total"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.total" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Submit
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <div class="py-12 px-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-end mb-4">
                    <!-- <Link href="/send-qr">Add Guest</Link> -->
                    <button @click="toggleModal">Add Guest</button>
                </div>

                <div v-if="!pagination.data?.length">
                    <p class="text-center">No Guest list yet</p>
                </div>
                <div v-else className="relative overflow-x-auto">
                    <table className="w-full text-sm text-left text-gray-500">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" className="px-6 py-3">#</th>
                                <th scope="col" className="px-6 py-3">Family</th>
                                <th scope="col" className="px-6 py-3">Phone</th>
                                <th scope="col" className="px-6 py-3">Children</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr className="bg-white border-b" v-for="(model, index) in pagination.data">
                                <td className="px-6 py-4">{{ index + 1 }}</td>
                                <td scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{model.family}}
                                </td>
                                <td className="px-6 py-4"> {{model.phone}} </td>
                                <td className="px-6 py-4"> {{model.children}} </td>
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
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const showModal = ref(false);
const $page: any = usePage();
const toggleModal = () => {
    showModal.value = !showModal.value;
}

const form = useForm({
    code: '234',
    family: '',
    children: '',
    phone: '',
    total: "0"
});

const submit = () => {
    form.post(route('guests.create'), {
        onFinish: () => {
            form.reset();
            toggleModal();
            // form.reset('password');
        }
    });
};

const pagination: any = computed(() => $page.props.models || []);
</script>