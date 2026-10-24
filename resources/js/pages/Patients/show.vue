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
import { Head, Link, router } from '@inertiajs/vue3';
import { MoveLeft, Pencil, Trash } from '@lucide/vue';
import ConfirmDeleteDialog from '@/components/ConfirmDeleteDialog.vue';
import { ref } from 'vue';
import patients from '@/routes/patients';
import { Patient, FollowUp } from '@/types/patient';
import type { Paginated } from '@/types/pagination';

const props = defineProps<{
    patient: Patient;
    patientFollowUps: Paginated<FollowUp>;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/dashboard',
            },
            {
                title: 'Patients',
                href: '/patients',
            },
            {
                title: 'Show Patient',
                href: '/patients/{patient.id}/show',
            },
        ],
    },
});

// for modals
const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

const confirmDelete = (patientId: number) => {
    deletingId.value = patientId;

    router.delete(patients.destroy(patientId).url, {
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
    <Head
        variant="small"
        title="Showing Patient"
        dessciption="showing patient details."
    />
    <div class="mx-8 flex w-full flex-col items-center justify-center">
        <div class="my-4 w-2/3 text-center">
            <Card>
                <div class="ms-4 flex w-full justify-start">
                    <Link
                        :href="patients.index()"
                        class="flex items-center gap-2"
                        ><MoveLeft color="white" /> Back</Link
                    >
                </div>
                <h1>Details of Patient "{{ props.patient.name }}"</h1>
                <div class="flex w-full items-start justify-between">
                    <div class="m-4 flex w-full flex-col gap-2 text-left">
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold">Name:</div>
                            <div class="w-full">{{ props.patient.name }}</div>
                        </div>
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold">Phone:</div>
                            <div class="w-full">{{ props.patient.phone }}</div>
                        </div>
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold text-nowrap">
                                E-mail:
                            </div>
                            <div class="w-full">{{ props.patient.email }}</div>
                        </div>
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold text-nowrap">
                                Address:
                            </div>
                            <div class="w-full">
                                {{ props.patient.address }} EGP
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex w-full flex-col justify-start p-4 text-left">
                    <h1>Patient FollowUps:</h1>
                    <Table class="">
                        <TableCaption
                            >Show {{ patientFollowUps.meta.from }} to
                            {{ patientFollowUps.meta.to }} of
                            {{ patientFollowUps.meta.total }}.</TableCaption
                        >
                        <TableHeader>
                            <TableRow class="uppercase">
                                <TableHead>Date</TableHead>
                                <TableHead>Time</TableHead>
                                <TableHead>Doctor</TableHead>
                                <TableHead>Notes</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="followup in patientFollowUps.data">
                                <TableCell class="">{{
                                    followup.date
                                }}</TableCell>
                                <TableCell class="">{{
                                    followup.time
                                }}</TableCell>
                                <TableCell class="w-[20%]">{{
                                    followup.doctor
                                }}</TableCell>
                                <TableCell class="">{{
                                    followup.notes
                                }}</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
                <div class="flex w-full flex-col justify-start p-4 text-left">
                    <h1>Patient Schedules:</h1>
                    <Table class="">
                        <TableCaption
                            >Show {{ 'follow.meta.from' }} to
                            {{ 'patient.meta.to' }} of
                            {{ 'patient.meta.total' }}.</TableCaption
                        >
                        <TableHeader>
                            <TableRow class="uppercase">
                                <TableHead>Date</TableHead>
                                <TableHead>Start Time</TableHead>
                                <TableHead>Duration</TableHead>
                                <TableHead>Patient Name</TableHead>
                                <TableHead>Booked By</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Notes</TableHead>
                                <TableHead class="text-center"
                                    >Actions</TableHead
                                >
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow>
                                <TableCell class="">{{
                                    patient.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    patient.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    patient.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    patient.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    patient.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    patient.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    patient.name
                                }}</TableCell>
                                <TableCell
                                    class="flex items-center justify-center gap-2"
                                >
                                    <Link
                                        :href="patients.edit(patient.id)"
                                        alt="Edit"
                                        ><Pencil
                                            class="text-green-500 hover:text-green-700"
                                    /></Link>
                                    <ConfirmDeleteDialog
                                        v-model="openDialogId"
                                        :title="`Delete ${patient.name}?`"
                                        description="Are you sure you want to delete this patient? This action cannot be undone."
                                        :processing="deletingId === patient.id"
                                        @confirm="confirmDelete(patient.id)"
                                    >
                                        <Trash
                                            class="crusor-pointer text-red-500 hover:text-red-700"
                                        />
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
