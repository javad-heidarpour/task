<script setup>
import draggable from 'vuedraggable';


import AppLayout from '@/Layouts/AppLayout.vue';
import IndexTr from './Index-tr.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from "axios";
import Spinner from "@/Componnet-Task/Spinner.vue";

import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    tasks: Object,
});
const SpinnerSohw = ref(false);
const nameInput = ref(null);
const priorityInput = ref(null);

const form = useForm({
    id: null,
    name: null,
    priority: null,
    created_at: null,
    updated_at: null,
});
var confirmingModal = ref(false);
const closeModal = () => {
    confirmingModal.value = false;
}
const save = () => {


    console.log('save', form);
    SpinnerSohw.value = true;
    axios.post(route("task.store"), form)
        .then(function (response) {
            console.log('222', response.data);

            form.reset();
            closeModal();
            SpinnerSohw.value = false;
       
            window.location.href = "task";
        })
        .catch(function (err) {
            form.errors = [];
            console.log('error', err.response);
            if (err && err.response.status == 422) {
                if (err.response.data.errors.name) {
                    nameInput.value.focus();
                    form.errors.name = err.response.data.errors.name[0];
                }
                if (err.response.data.errors.priority) {
                    priorityInput.value.focus();
                    form.errors.priority = err.response.data.errors.priority[0];
                }
            }
            SpinnerSohw.value = false;

        });

};
</script>

<template>
    <AppLayout title="Dashboard">


        <div class="relative rounded-xl overflow-auto m-2 border bg-white">
            <div class="shadow-sm overflow-hidden my-8">
                <span @click="confirmingModal = true"
                    class="m-5 bg-purple-600 px-2 border text-white border-purple-400 rounded hover:bg-purple-200 hover:text-purple-600 cursor-pointer">
                    Create New Task
                </span>
                <table class="border-collapse table-auto w-full text-sm text-center ">
                    <thead class="border-b font-bold bg-purple-100">
                        <tr>
                            <td>id</td>
                            <td>name</td>
                            <td>priority</td>
                            <td>opration</td>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(task, index)  in tasks" :key="index">
                            <IndexTr :task="task" />

                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>

    <!-- ---- -->
    <DialogModal :show="confirmingModal" @close="closeModal">
        <Spinner v-if="SpinnerSohw" />

        <template #title>
            Create Task
        </template>

        <template #content>
            <Spinner v-if="SpinnerSohw" />

            To create a new task, please enter the following information carefully.
            <div class="mt-4">
                <TextInput ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4" placeholder="Name"
                    autocomplete="current-name" @keyup.enter="save" />

                <InputError :message="form.errors.name" class="mt-2" />
                <TextInput ref="priorityInput" v-model="form.priority" type="number" min="0" max="100"
                    class="mt-1 block w-3/4" placeholder="priority" autocomplete="current-priority" @keyup.enter="save" />
                <InputError :message="form.errors.priority" class="mt-2" />
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click="save">
                Save
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
