<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Table,
    TableCaption,
    TableHead,
    TableHeader,
    TableRow,
    TableBody,
    TableCell,

 } from '@/components/ui/table';
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination';
import { Eye, Pencil, Plus, Search, Trash } from '@lucide/vue';
import { Link, router } from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import ConfirmDeleteDialog from '@/components/ConfirmDeleteDialog.vue';
import patientsroute from '@/routes/patients';
import { ref, watch } from 'vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/',
            },
            {
                title: 'Patients',
                href: '/patients',
            },
        ],
    },
});

interface Patient {
    id: number;
    name: string;
    email: string;
    phone: string;
    address: string;
}

const props = defineProps<{
    patients: Patient[];
}>();

const search = ref<string | null>();
let debounceTimer: ReturnType<typeof setTimeout> | null = null;

watch(search, (value)=>{
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
    router.get('/doctors', { search: value }, {preserveState: true, preserveScroll: true, only: ['patients']});
    }
    , 500);
})

function goToPage(page: any)
{
    router.get('/patients', { page }, {preserveState: true, preserveScroll: true, only: ['patients']});
}

// for modals
const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

//for delete modal confomation
const confirmDelete = (patientId: number) => {
    deletingId.value = patientId;

    router.delete(patientsroute.destroy(patientId).url, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            openDialogId.value = null;
        },
        onFinish: () => {
            deletingId.value = null;
        },
    });
};

console.log(JSON.stringify(props.patients));
</script>

<template>
    <div class="flex justify-between mx-8 my-2">
        <div class="flex gap-2 items-center"><Input v-model="search" placeholder="Search..." /><Search /></div>
        <div class="flex">
            <Link href="patients/create"><Button><Plus /> New Patient</Button></Link>
        </div>
    </div>
    <div class="flex justify-center m-8">
        <Table class="w-full">
            <TableCaption>Show {{ patients.meta.from }} to {{ patients.meta.to }} of {{ patients.meta.total }}.</TableCaption>
            <TableHeader>
                <TableRow class="uppercase">
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Phone</TableHead>
                    <TableHead>Address</TableHead>
                    <!-- <TableHead>Follow Ups</TableHead> -->
                    <TableHead class="text-center">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="patient in patients.data" :key="'patient-'+patient.id">
                    <TableCell class="w-[15%]">{{ patient.name }}</TableCell>
                    <TableCell class="w-[15%]">{{ patient.email }}</TableCell>
                    <TableCell class="w-[15%]">{{ patient.phone }}</TableCell>
                    <TableCell>{{ patient.address }}</TableCell>
                    <!-- <TableCell v-if="patient.followUps.length"><span v-for="followUp in patient.followUps" :key="'followup-'+followUp.id">- Doctor: {{ followUp.patient }} @ Date: {{ followUp.date }} {{ followUp.time }}<br /> Notes: {{ followUp.notes }}, <br /></span></TableCell>
                    <TableCell class="text-center" v-else><span class="text-center">No Follow Up Yet.</span></TableCell> -->
                    <TableCell class="flex justify-center gap-2 text-white">
                        <Link :href="patientsroute.show(patient.id)" alt="Show"><Eye class="text-blue-500 hover:text-blue-700" /></Link>
                        <Link :href="patientsroute.edit(patient.id)" alt="Edit"><Pencil class="text-green-500 hover:text-green-700" /></Link>
                        <ConfirmDeleteDialog
                        v-model:open="openDialogId"
                        :title="`Delete ${patient.name}?`"
                        description="Are you sure you want to delete this Patient? This action cannot be undone."
                        :processing="deletingId === patient.id"
                        @confirm="confirmDelete(patient.id)"
                    >

                            <Trash class="text-red-500 hover:text-red-700 crusor-pointer" />
                        </ConfirmDeleteDialog>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
    <div class="flex justify-end me-4">
        <div v-if="patients.meta.total > patients.meta.per_page" class="flex flex-col justify-end gap-6">
            <Pagination v-slot="{ page }" :items-per-page="patients.meta.per_page" :total="patients.meta.total" :default-page="patients.meta.current_page" @update:page="goToPage">
            <PaginationContent v-slot="{ items }">
                <PaginationPrevious />

                <template v-for="(item, index) in items" :key="index">
                <PaginationItem
                    v-if="item.type === 'page'"
                    :value="item.value"
                    :is-active="item.value === page"
                >
                    {{ item.value }}
                </PaginationItem>
                </template>

                <PaginationEllipsis :index="4" />

                <PaginationNext />
            </PaginationContent>
            </Pagination>
        </div>
    </div>
</template>

<style scoped>

</style>
