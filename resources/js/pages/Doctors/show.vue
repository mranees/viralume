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
import { Head, Link, router } from '@inertiajs/vue3';
import { MoveLeft, Pencil, Trash } from '@lucide/vue';
import ConfirmDeleteDialog from '@/components/ConfirmDeleteDialog.vue';
import { ref } from 'vue';
import { Doctor } from '@/types/doctor';

defineOptions({
    layout: {
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
    },
});

const props = defineProps<{
    doctor: Doctor;
}>();

// for delete modals
const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

const confirmDelete = (doctorId: number) => {
    deletingId.value = doctorId;

    router.delete(doctors.destroy(doctorId).url, {
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
        title="Showing Doctor {{ props.doctor.name }}"
        dessciption="showing doctor {{ props.doctor.name }} details."
    />
    <div class="mx-8 flex w-full flex-col items-center justify-center">
        <div class="my-4 w-2/3 text-center">
            <Card>
                <div class="ms-4 flex w-full justify-start">
                    <Link
                        :href="doctors.index()"
                        class="flex items-center gap-2"
                        ><MoveLeft color="white" /> Back</Link
                    >
                </div>
                <h1>Details of Doctor "{{ props.doctor.name }}"</h1>
                <img
                    :src="props.doctor.profile_image"
                    class="m-auto flex h-48 w-48 items-center justify-center rounded-full border border-blue-500"
                />
                <div class="flex w-full items-start justify-between">
                    <div class="m-4 flex w-1/3 flex-col gap-2 text-left">
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold">Name:</div>
                            <div class="w-full">{{ props.doctor.name }}</div>
                        </div>
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold">Phone:</div>
                            <div class="w-full">{{ props.doctor.phone }}</div>
                        </div>
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold text-nowrap">
                                E-mail:
                            </div>
                            <div class="w-full">{{ props.doctor.email }}</div>
                        </div>
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold text-nowrap">
                                Vizita Price:
                            </div>
                            <div class="w-full">
                                {{ props.doctor.vizita_price }} EGP
                            </div>
                        </div>
                        <div class="flex w-full items-center gap-2">
                            <div class="text-lg font-bold">
                                Specializations:
                            </div>
                            <div class="w-full">
                                <span
                                    v-for="spec in props.doctor.specializations"
                                    :key="'spec' + spec.id"
                                    >{{ spec.name }},</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="m-4 flex w-2/3 flex-col gap-2 text-left">
                        <div class="flex w-full flex-col gap-2">
                            <div class="w-full text-lg font-bold text-nowrap">
                                Short Bio:
                            </div>
                            <div class="w-full">{{ props.doctor.bio }}</div>
                        </div>
                    </div>
                </div>
                <div class="flex w-full flex-col justify-start p-4 text-left">
                    <h1>Doctor Schedules:</h1>
                    <Table class="">
                        <TableCaption
                            >Show {{ 'doctors.meta.from' }} to
                            {{ 'doctors.meta.to' }} of
                            {{ 'doctors.meta.total' }}.</TableCaption
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
                                    doctor.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    doctor.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    doctor.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    doctor.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    doctor.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    doctor.name
                                }}</TableCell>
                                <TableCell class="">{{
                                    doctor.name
                                }}</TableCell>
                                <TableCell
                                    class="flex items-center justify-center gap-2"
                                >
                                    <Link
                                        :href="doctors.edit(doctor.id)"
                                        alt="Edit"
                                        ><Pencil
                                            class="text-green-500 hover:text-green-700"
                                    /></Link>
                                    <ConfirmDeleteDialog
                                        v-model:open="openDialogId"
                                        :title="`Delete ${doctor.name}?`"
                                        description="Are you sure you want to delete this doctor? This action cannot be undone."
                                        :processing="deletingId === doctor.id"
                                        @confirm="confirmDelete(doctor.id)"
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
