<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import IndexTr from './Index-tr.vue';


defineProps({
    tasks: Object,
});
</script>

<template>
    <AppLayout title="Dashboard">


        <div class="relative rounded-xl overflow-auto m-2 border bg-white">
            <div class="shadow-sm overflow-hidden my-8">

                <table class="border-collapse table-auto w-full text-sm text-center ">
                    <thead class="border-b font-bold bg-sky-50">
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
    <!-- ----- -->
    <DialogModal :show="confirmingEditTask" @close="closeModal">
        <template #title>
            Edit Task
        </template>

        <template #content>
            You can edit your work in this window.

            <div class="mt-4">
                <TextInput ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4" placeholder="Name"
                    autocomplete="current-name" @keyup.enter="save" />

                <InputError v-if="form.errors.name" :message="form.errors.name" class="mt-2" />
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
