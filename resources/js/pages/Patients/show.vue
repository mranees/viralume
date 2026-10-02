<script setup lang="ts">
import {
    Table,
    TableCaption,
    TableHead,
    TableHeader,
    TableRow,
    TableBody,
    TableCell,

} from '@/components/ui/table';
import Card from '@/components/ui/card/Card.vue';
import doctors from '@/routes/doctors';
import { Link, router } from '@inertiajs/vue3';
import { MoveLeft, Pencil, Trash } from '@lucide/vue';
import ConfirmDeleteDialog from '@/components/ConfirmDeleteDialog.vue';
import { ref } from 'vue';
import patients from '@/routes/patients';

interface Patient {
    id: number;
    name: string;
    email: string;
    phone: string;
    address: string;
}

const props = defineProps<{
    patient: Patient;
}>();

defineOptions({
    layout:{
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/',
            },
            {
                title: 'Doctors',
                href: '/doctors',
            },
            {
                title: 'Show Doctor',
                href: '/doctors/{doctor.id}/show',
            },
        ],
    }
})

// for modals
const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

const confirmDelete = (patientId: number) => {
    deletingId.value = patientId;

    router.delete(doctors.destroy(patientId).url, {
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
</script>
<template>
    <div class=" w-full flex flex-col justify-center items-center mx-8 ">
        <div class="w-2/3 my-4 text-center">
            <Card>
                <div class="flex justify-start w-full ms-4">
                    <Link :href="doctors.index()" class="flex items-center gap-2"><MoveLeft color="white" /> Back</Link>
                </div>
                <h1>Details of Doctor "{{ props.patient.name }}"</h1>
                <div class="w-full flex justify-between items-start">
                    <div class="w-1/3 text-left flex flex-col gap-2 m-4">
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg ">Name:</div>
                            <div class="w-full">{{ props.patient.name }}</div>
                        </div>
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg ">Phone:</div>
                            <div class="w-full">{{ props.patient.phone }}</div>
                        </div>
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg text-nowrap">E-mail:</div>
                            <div class="w-full">{{ props.patient.email }}</div>
                        </div>
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg text-nowrap">Address:</div>
                            <div class="w-full">{{ props.patient.address }} EGP</div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col justify-start text-left p-4">
                    <h1>Patient Schedules:</h1>
                    <Table class="">
                        <TableCaption>Show {{ 'patient.meta.from' }} to {{ 'patient.meta.to' }} of {{ 'patient.meta.total' }}.</TableCaption>
                        <TableHeader>
                            <TableRow class="uppercase">
                                <TableHead>Date</TableHead>
                                <TableHead>Start Time</TableHead>
                                <TableHead>Duration</TableHead>
                                <TableHead>Patient Name</TableHead>
                                <TableHead>Booked By</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Notes</TableHead>
                                <TableHead class="text-center">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow>
                                <TableCell class="">{{ patient.name }}</TableCell>
                                <TableCell class="">{{ patient.name }}</TableCell>
                                <TableCell class="">{{ patient.name }}</TableCell>
                                <TableCell class="">{{ patient.name }}</TableCell>
                                <TableCell class="">{{ patient.name }}</TableCell>
                                <TableCell class="">{{ patient.name }}</TableCell>
                                <TableCell class="">{{ patient.name }}</TableCell>
                                <TableCell class="flex gap-2 justify-center items-center">
                                    <Link :href="patients.edit(patient.id)" alt="Edit"><Pencil class="text-green-500 hover:text-green-700" /></Link>
                                    <ConfirmDeleteDialog
                                    v-model:open="openDialogId"
                                    :title="`Delete ${patient.name}?`"
                                    description="Are you sure you want to delete this patient? This action cannot be undone."
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
            </Card>
        </div>
    </div>
</template>
