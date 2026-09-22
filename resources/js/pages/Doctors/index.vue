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
                title: 'Doctors',
                href: '/doctors',
            }
        ],
    },
});
defineProps({
    doctors: Object,
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
                    <TableHead>Specializations</TableHead>
                    <TableHead>Bio</TableHead>
                    <TableHead>Vizita Price</TableHead>
                    <TableHead>Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="doctor in doctors.data" :key="'doctor-'+doctor.id">
                    <TableCell>{{ doctor.name }}</TableCell>
                    <TableCell>{{ doctor.email }}</TableCell>
                    <TableCell>{{ doctor.phone }}</TableCell>
                    <TableCell><span v-for="spec in doctor.specializations" :key="'spec-'+spec.id">{{ spec.name }}, </span></TableCell>
                    <TableCell class=" text-ellipsis">{{ doctor.bio }}</TableCell>
                    <TableCell>{{ doctor.vizita_price }} EGP</TableCell>
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
