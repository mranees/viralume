<script setup>
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
import { Pencil, Trash } from '@lucide/vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Patients',
                href: '/patients',
            }
        ],
    },
});
defineProps({
    patients: Object,
})
</script>

<template>

    <div class="flex justify-center">
        <Table class="w-full">
            <TableCaption>A list of Doctors.</TableCaption>
            <TableHeader>
                <TableRow class="uppercase">
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Phone</TableHead>
                    <TableHead>Follow Up</TableHead>
                    <TableHead>Address</TableHead>
                    <TableHead>Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="patient in patients.data" :v-key="'patient-'+patient.id">
                    <TableCell>{{ patient.name }}</TableCell>
                    <TableCell>{{ patient.email }}</TableCell>
                    <TableCell>{{ patient.phone }}</TableCell>
                    <TableCell v-if="patient.follow_up">sss<span v-for="follow_up in patient.follow_up" :key="'followup-'+follow_up.id">- {{ follow_up }}, <br /></span></TableCell>
                    <TableCell v-else><span>No Follow Up Yet.</span></TableCell>
                    <TableCell class=" text-ellipsis">{{ patient.address }}</TableCell>
                    <TableCell class="flex justify-center gap-2 text-white">
                        <Button class="bg-green-500 "><Pencil /> Edit</Button>
                        <Button class="bg-red-500 text-white"><Trash /> Delete</Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

<style lang="scss" scoped>

</style>
