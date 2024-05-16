<template>
    <Head title="Welcome" />
    <div class="h-screen bg-pink-500">
        <div class="lg:max-w-7xl h-full mx-auto flex items-center justify-center p-3">
            <div class="md:w-1/3 p-3">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front rounded">
                            <img src="images/banner.jpeg" alt="Avatar" style="width: 100%; height: 100%">
                        </div>
                        <div class="flip-card-back rounded text-left p-5">
                          <form @submit.prevent="submit">
                            <h4 class="text-2xl font-bold text-black">Enter your Details</h4>
                            <p class="mb-6 text-sm text-slate-500">Slay the day with Freida is turning 5</p>
                            <div class="mb-4">
                                <InputLabel for="email" value="Name" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mb-8">
                                <InputLabel for="email" value="Phone" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="text-end">
                                <PrimaryButton class="px-10" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    RSVP
                                </PrimaryButton>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};

</script>

<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

.flip-card {
  background-color: transparent;
  width: 450px;
  height: 500px;
  perspective: 1000px;
}

@media screen and (max-width: 600px) {
  .flip-card {
    width: 350px;
  }
}

.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  border-radius: 10px;
  transition: transform 0.6s;
  transform-style: preserve-3d;
  /* box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); */
}

.flip-card:hover .flip-card-inner {
  transform: rotateY(180deg);
}

.flip-card-front, .flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
}

.flip-card-front {
  background-color: #bbb;
  color: black;
}

.flip-card-back {
  background-color: #fff;
  color: white;
  transform: rotateY(180deg);
}
</style>
