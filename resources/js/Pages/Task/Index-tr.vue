<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
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
    task: Object,
});
const form = useForm({
    id: null,
    name: null,
    priority: null,
    created_at: null,
    updated_at: null,
});
const nameInput = ref(null);
const priorityInput = ref(null);
const SpinnerSohw = ref(false);
const confirmingEditTask = ref(false);

const closeModal = () => {
    confirmingEditTask.value = false;

    form.reset();
};
const editTask = (task) => {
    confirmingEditTask.value = true;


    form.id = task.id;
    form.name = task.name;
    form.priority = task.priority;

}
const save = () => {
    console.log('save', props.task);

    form.id = props.task.id;
    form.name = props.task.name;
    form.priority = props.task.priority;

    console.log('save', form);
    SpinnerSohw.value = true;
    axios.put(route("task.update2"), form)
        .then(function (response) {
            console.log('222', response.data);
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

    // form.put(route('task.update2'), {
    //     preserveScroll: true,
    //     onSuccess: () => closeModal(),
    //     onError: () => nameInput.value.focus(),
    //     onFinish: (res) => {
    //         console.log(res.data);
    //         if (res.data) {
    //             form.id = res.data.id;
    //             form.name = res.data.name;
    //             form.priority = res.data.priority;
    //             // props.task = res.data;
    //         }
    //         form.reset();
    //     },
    // });
};
</script>

<template>
    <tr>
        <td class="border">
            {{ task.id }}
        </td>
        <td class="border">

            {{ task.name }}

        </td>
        <td class="border">

            {{ task.priority }}

        </td>
        <td class="border">

            <span @click="editTask(task);"
                class="bg-green-100 px-2 border text-green-600 border-green-400 rounded hover:bg-green-200 cursor-pointer">
                Edit
            </span>
        </td>
    </tr>
    <!-- ----- -->
    <DialogModal :show="confirmingEditTask" @close="closeModal">
        <template #title>
            Edit Task
        </template>

        <template #content>
            <Spinner v-if="SpinnerSohw" />

            You can edit your work in this window.

            <div class="mt-4">
                <TextInput ref="nameInput" v-model="task.name" type="text" class="mt-1 block w-3/4" placeholder="Name"
                    autocomplete="current-name" @keyup.enter="save" />

                <InputError :message="form.errors.name" class="mt-2" />
                <TextInput ref="priorityInput" v-model="task.priority" type="number" min="0" max="100"
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
