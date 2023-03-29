<script setup>

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

import draggable from 'vuedraggable';
// const meals = ref([
//     'Hamburger',
//     'Pizza',
//     'Spaghetti',
//     'Tacos',
//     'Teriyaki Chicken',
// ]);
var tasks = ref(null);

const SpinnerSohw = ref(false);
const SpinnerSohw2 = ref(false);
const nameInput = ref(null);
const priorityInput = ref(null);
const saveMode = ref('Create');
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
    SpinnerSohw.value = false;
}
const Save = () => {

    console.log('saveMode =', saveMode.value);
    // return;
    SpinnerSohw.value = true;
    if (saveMode.value == 'Create')
        axios.post(route("task.store"), form)
            .then(function (response) {
                console.log('Create = ', response.data);

                form.reset();
                closeModal();
                SpinnerSohw.value = false;

                // window.location.href = "task";
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
    else if (saveMode.value == 'Edit') {
        console.log('save Edit =', form);
        // return;
        SpinnerSohw.value = true;
        axios.put(route("task.update2"), form)
            .then(function (response) {
                console.log('Edit = ', response.data);
                form.reset();
                closeModal();
                SpinnerSohw.value = false;

            })
            .catch(function (err) {
                form.errors = [];
                console.log('222', err.response);
                if (err.response.status == 422) {
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
    }
    load();


};
const load = () => {

    // SpinnerSohw.value = true;
    axios.get(route("task.load"))
        .then(function (response) {
            tasks.value = response.data;
            console.log('tasks.value = ', tasks.value);

            // SpinnerSohw.value = false;


        })
        .catch(function (err) {
            // form.errors = [];
            // console.log('222', err.response);
            // if (err.response.status == 422) {
            //     if (err.response.data.errors.name) {
            //         nameInput.value.focus();
            //         form.errors.name = err.response.data.errors.name[0];
            //     }
            //     if (err.response.data.errors.priority) {
            //         priorityInput.value.focus();
            //         form.errors.priority = err.response.data.errors.priority[0];
            //     }
            // }
            // SpinnerSohw.value = false;

        });

};
const changePriority = () => {

    SpinnerSohw2.value = true;
    axios.post(route("task.changePriority"), tasks.value)
        .then(function (response) {
            // tasks.value = response.data;
            console.log('tasks.value = ', response.data);

            SpinnerSohw2.value = false;


        })
        .catch(function (err) {
            // form.errors = [];
            console.log('222', err.response);
            // if (err.response.status == 422) {
            //     if (err.response.data.errors.name) {
            //         nameInput.value.focus();
            //         form.errors.name = err.response.data.errors.name[0];
            //     }
            //     if (err.response.data.errors.priority) {
            //         priorityInput.value.focus();
            //         form.errors.priority = err.response.data.errors.priority[0];
            //     }
            // }
            SpinnerSohw2.value = false;

        });

};
load();
const editTask = (task) => {
    confirmingModal.value = true;
    saveMode.value = 'Edit';
    form.id = task.id;
    form.name = task.name;
    form.priority = task.priority;

}
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="relative rounded-xl overflow-auto m-2 border bg-white">
            <div class="shadow-sm overflow-hidden my-8">
                <Spinner v-if="SpinnerSohw2" />

                <span @click="confirmingModal = true; saveMode = 'Create'; form.reset();"
                    class="m-5 bg-purple-600 px-2 border text-white border-purple-400 rounded hover:bg-purple-200 hover:text-purple-600 cursor-pointer">
                    Create New Task
                </span>
                <span v-if="tasks" @click="changePriority()"
                    class="m-5 bg-rose-600 px-2 border text-white border-rose-400 rounded hover:bg-rose-200 hover:text-rose-600 cursor-pointer">
                    Save priority's tasks
                </span>
                <h1 class="bg-gray-400 text-white mx-5 my-2 text-center mt-5">Task List</h1>
                <draggable v-model="tasks" tag="ul" class="ui-sortable ">
                    <template #item="{ element: task }">
                        <li
                            class="cursor-grab ui-state-default ui-sortable-handle border mx-5 my-2 rounded px-2 hover:bg-gray-100	">
                            {{ task.name }}
                            <span class="mx-2 px-3 text-orange-600 text-xs">
                                (Priority =  {{ task.priority }} )

                            </span>
                            <span @click="editTask(task);"
                                class="bg-green-100 ml-10 px-2 border text-green-600 border-green-400 rounded hover:bg-green-200 cursor-pointer">
                                Edit
                            </span>
                        </li>
                    </template>
                </draggable>
            </div>
        </div>
        <div>

        </div>
    </AppLayout>
    <!-- ---- -->
    <DialogModal :show="confirmingModal" @close="closeModal">
        <Spinner v-if="SpinnerSohw" />

        <template #title>
            {{ saveMode }} Task
        </template>

        <template #content>
            <Spinner v-if="SpinnerSohw" />

            To {{ saveMode }} a new task, please enter the following information carefully.
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
                @click="Save">
                Save
            </PrimaryButton>
        </template>
    </DialogModal>
</template>