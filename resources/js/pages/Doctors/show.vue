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
interface Doctor {
    id: number;
    name: string;
    email: string;
    phone: string;
    vizita_price: number;
    bio: string;
    profile_image: string;
    is_active: boolean;
    specializations: Array<{ id: number; name: string }>;
}
const props = defineProps<{
    doctor: Doctor,
}>();

// for modals
const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

const confirmDelete = (doctorId: number) => {
    deletingId.value = doctorId;

    router.delete(doctors.destroy(doctorId).url, {
        preserveScroll: true,
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
                <h1>Details of Doctor "{{ props.doctor.name }}"</h1>
                <img :src="props.doctor.profile_image" class="flex items-center justify-center m-auto w-48 h-48 rounded-full border border-blue-500" />
                <div class="w-full flex justify-between items-start">
                    <div class="w-1/3 text-left flex flex-col gap-2 m-4">
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg ">Name:</div>
                            <div class="w-full">{{ props.doctor.name }}</div>
                        </div>
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg ">Phone:</div>
                            <div class="w-full">{{ props.doctor.phone }}</div>
                        </div>
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg text-nowrap">E-mail:</div>
                            <div class="w-full">{{ props.doctor.email }}</div>
                        </div>
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg text-nowrap">Vizita Price:</div>
                            <div class="w-full">{{ props.doctor.vizita_price }} EGP</div>
                        </div>
                        <div class="w-full flex gap-2 items-center">
                            <div class="font-bold text-lg ">Specializations:</div>
                            <div class="w-full"><span v-for="spec in props.doctor.specializations" :key="'spec'+spec.id">{{ spec.name }},</span></div>
                        </div>
                    </div>
                    <div class="w-2/3 text-left flex flex-col gap-2 m-4">
                        <div class="w-full flex flex-col gap-2">
                            <div class="w-full font-bold text-lg text-nowrap">Short Bio:</div>
                            <div class="w-full">{{ props.doctor.bio }}</div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col justify-start text-left p-4">
                    <h1>Doctor Schedules:</h1>
                    <Table class="">
                        <TableCaption>Show {{ 'doctors.meta.from' }} to {{ 'doctors.meta.to' }} of {{ 'doctors.meta.total' }}.</TableCaption>
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
                                <TableCell class="">{{ doctor.name }}</TableCell>
                                <TableCell class="">{{ doctor.name }}</TableCell>
                                <TableCell class="">{{ doctor.name }}</TableCell>
                                <TableCell class="">{{ doctor.name }}</TableCell>
                                <TableCell class="">{{ doctor.name }}</TableCell>
                                <TableCell class="">{{ doctor.name }}</TableCell>
                                <TableCell class="">{{ doctor.name }}</TableCell>
                                <TableCell class="flex gap-2 justify-center items-center">
                                    <Link :href="doctors.edit(doctor.id)" alt="Edit"><Pencil class="text-green-500 hover:text-green-700" /></Link>
                                    <ConfirmDeleteDialog
                                    v-model:open="openDialogId"
                                    :title="`Delete ${doctor.name}?`"
                                    description="Are you sure you want to delete this doctor? This action cannot be undone."
                                    :processing="deletingId === doctor.id"
                                    @confirm="confirmDelete(doctor.id)"
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
