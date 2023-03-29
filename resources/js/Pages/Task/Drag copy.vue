<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import { ref } from 'vue';
import draggable from 'vuedraggable';
// const meals = ref([
//     'Hamburger',
//     'Pizza',
//     'Spaghetti',
//     'Tacos',
//     'Teriyaki Chicken',
// ]);
var tasks = ref(null);
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
load();

</script>

<template>
    <AppLayout title="Dashboard">


        <div class="relative rounded-xl overflow-auto m-2 border bg-white">
            <div class="shadow-sm overflow-hidden my-8">
                <span @click="confirmingModal = true"
                    class="m-5 bg-purple-600 px-2 border text-white border-purple-400 rounded hover:bg-purple-200 hover:text-purple-600 cursor-pointer">
                    Create New Task
                </span>

                <draggable v-model="tasks" :itemKey="task.priority" tag="table" class="border-collapse table-auto w-full text-sm text-center ">
                    <thead class="border-b font-bold bg-purple-100">
                        <tr>

                            <td>name</td>
                            <td>priority</td>
                            <td>opration</td>
                        </tr>
                    </thead>

                    <template #item="{ element: task }">
                        <tbody>
                            <tr class="cursor-grab	">
                                <td>
                                    {{ task.name }}
                                </td>
                                <td>
                                    {{ task.priority }}
                                </td>
                            </tr>
                        </tbody>

                    </template>
                </draggable>
                <span @click="confirmingModal = true"
                    class="m-5 bg-rose-600 px-2 border text-white border-rose-400 rounded hover:bg-rose-200 hover:text-rose-600 cursor-pointer">
                    Save priority's  tasks
                </span>
            </div>
        </div>
    </AppLayout>
</template>