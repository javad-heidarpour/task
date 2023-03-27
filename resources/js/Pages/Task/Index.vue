<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    tasks: Object,
});
const task = useForm({
    id: null,
    name: null,
    priority: null,
    created_at: null,
    updated_at: null,
});
const nameInput = ref(null);
const priorityInput = ref(null);

const confirmingEditTask = ref(false);

const closeModal = () => {
    confirmingEditTask.value = false;

    task.reset();
};
const ecitTask = (task) => {
    confirmingEditTask.value = true;


    task.id = task.id;
    task.name = task.name;
    task.priority = task.priority;

}
const save = () => {
    console.log('save', task);
    task.put(route('task.edit'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => nameInput.value.focus(),
        onFinish: () => task.reset(),
    });
};
</script>

<template>
    <AppLayout title="Dashboard">


        <div class="relative rounded-xl overflow-auto m-2 border bg-white">
            <div class="shadow-sm overflow-hidden my-8">

                <table class="border-collapse table-auto w-full text-sm text-center">
                    <thead class="border-b font-bold bg-sky-50">
                        <tr>
                            <td>id</td>
                            <td>name</td>
                            <td>priority</td>
                            <td>opration</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(task, index)  in tasks" :key="index">
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

                                <span @click="ecitTask(task);"
                                    class="bg-green-100 px-2 border text-green-600 border-green-400 rounded hover:bg-green-200 cursor-pointer">
                                    Edit
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
    <!-- ----- -->
    <DialogModal :show="confirmingEditTask" @close="closeModal">
        <template #title>
            Edit Task
        </template>

        <template #content>
            You can edit your work in this window.

            <div class="mt-4">
                <TextInput ref="nameInput" v-model="task.name" type="text" class="mt-1 block w-3/4" placeholder="Name"
                    autocomplete="current-name" @keyup.enter="save" />

                <InputError :message="task.errors.priority" class="mt-2" />
                <TextInput ref="priorityInput" v-model="task.priority" type="number" min="0" max="100"
                    class="mt-1 block w-3/4" placeholder="priority" autocomplete="current-priority" @keyup.enter="save" />
                <InputError :message="task.errors.priority" class="mt-2" />
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton class="ml-3" :class="{ 'opacity-25': task.processing }" :disabled="task.processing"
                @click="save">
                Save
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
