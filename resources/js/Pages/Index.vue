<template>
    <Head title="Welcome" />
    <div class="h-screen" :class="'bg-cover'" style="overflow: hidden;">
        <div class="lg:max-w-7xl h-full mx-auto flex items-center justify-center p-3">
            <div class="md:w-1/3 p-3">
        
                <!-- <vueTypedJs :strings="['First text', 'Second Text']">
                  <h1 class="typing"></h1>
                </vueTypedJs> -->
                <!-- <vt text='Hello World! I was registered globally!'></vt> -->

                <div v-if="!isReady" class="text-center px-3 nanum-gothic-bold">
                  <h1 class="animate__animated animate__lightSpeedInLeft text-6xl md:text-8xl font-bold pacifico-regular text-center text-pink-400">Freida</h1>
                  <h1 class="animate__animated animate__zoomIn animate__delay-2s text-6xl md:text-8xl font-bold text-center text-white">is</h1>
                  <h1 class="animate__animated animate__lightSpeedInRight animate__delay-4s text-6xl md:text-8xl font-bold text-center text-white">5</h1>
                </div>

                <div v-if="isReady">
                  <div v-if="$page.props.flash.message" class="alert text-white mb-4 font-bold">
                    {{ $page.props.flash.message }}
                  </div>
                  
                  <h4 class="mb-4 text-pink-500 font-bold">Click the image to continue!</h4>
                  <div class="animate__animated animate__heartBeat flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front rounded">
                            <img src="images/banner.jpeg" alt="Avatar" style="width: 100%; height: 100%">
                        </div>
                        <div class="flip-card-back rounded text-left p-5">
                          <form @submit.prevent="submit">
                            <h4 class="text-2xl font-bold text-pink-600">Enter your Details</h4>
                            <p class="mb-6 text-sm text-slate-500 pacifico-regular">Slay the day! <strong>Freida</strong> is turning 5</p>
                            <div class="mb-4">
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />

                                <InputError class="mt-2" :message="form.errors.name" />
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

                            <h4 class="text-black">Your children</h4>
                            <p class="text-slate-500 text-sm mb-2">Names of those that are coming.</p>
                            <div class="mb-4">
                                <!-- <InputLabel for="email" value="Email" /> -->
                                <div class="flex items-center gap-3" v-for="(child, index) in form.children"> 
                                  <TextInput
                                    type="text"
                                    class="mt-1 block w-full flex-1"
                                    v-model="child.name"
                                    required
                                  />
                                  <i v-if="index > 0" class="fa-solid fa-trash cursor-pointer text-red-500 text-sm" @click="remove(index)"></i>
                                </div>
                                <InputError class="mt-2" :message="form.errors.children" />

                                <div class="mt-6">
                                  <span class="bg-pink-600" style="display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; margin: auto; color: white; cursor: pointer;" @click="addChild()">
                                    +
                                  </span>
                                </div>
                            </div>

                            <div class="text-end">
                                <PrimaryButton class="px-16 bg-pink-600 hover:bg-pink-700" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{ form.processing ? 'Please wait...' : 'RSVP' }}
                                </PrimaryButton>
                            </div>
                          </form>
                        </div>
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
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
// import vt from 'vue-typer';
// import VueTypedJs from 'vue-typed-js'

const isReady = ref(false);
const $page: any = usePage();

const form = useForm({
  code: '234',
  name: '',
  phone: '',
  children: [
    {name: '' }
  ]
});

const addChild = () => {
  form.children.push({name: ''})
}

const remove = (index: number) => {
  form.children.splice(index, 1);
}

const submit = () => {
    form.post(route('rsvp'), {
        onFinish: () => {
          // form.reset();
        },
        onSuccess: () => {
          form.reset();
        }
    });
};

setTimeout(() => {
  isReady.value = true
}, 10000);

</script>

<style>

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

/* .flip-card:hover .flip-card-inner:not(.no-flip) {
  transform: rotateY(180deg);
} */

/* .flip-card .flip-card-inner.no-flip {
  transform: none;
} */

.flip-card-front, .flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  overflow: auto;
}

.flip-card-front {
  background-color: #bbb;
  color: black;
}

.flip-card-back {
  background-color: #fff;
  /* color: white; */
  transform: rotateY(180deg);
}
</style>
