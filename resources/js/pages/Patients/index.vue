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
import { Eye, Pencil, Trash } from '@lucide/vue';

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

    <div class="flex justify-center m-8">
        <Table class="w-full">
            <TableCaption>A list of Patients.</TableCaption>
            <TableHeader>
                <TableRow class="uppercase">
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Phone</TableHead>
                    <TableHead>Address</TableHead>
                    <!-- <TableHead>Follow Ups</TableHead> -->
                    <TableHead>Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="patient in patients.data" :key="'patient-'+patient.id">
                    <TableCell>{{ patient.name }}</TableCell>
                    <TableCell>{{ patient.email }}</TableCell>
                    <TableCell>{{ patient.phone }}</TableCell>
                    <TableCell class=" text-ellipsis">{{ patient.address }}</TableCell>
                    <!-- <TableCell v-if="patient.followUps.length"><span v-for="followUp in patient.followUps" :key="'followup-'+followUp.id">- Doctor: {{ followUp.doctor }} @ Date: {{ followUp.date }} {{ followUp.time }}<br /> Notes: {{ followUp.notes }}, <br /></span></TableCell>
                    <TableCell class="text-center" v-else><span class="text-center">No Follow Up Yet.</span></TableCell> -->
                    <TableCell class="flex justify-center gap-2 text-white">
                        <Button ><Eye /> Show</Button>
                        <Button class="bg-green-500 "><Pencil /> Edit</Button>
                        <Button class="bg-red-500 text-white"><Trash /> Delete</Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

<style scoped>

</style>
