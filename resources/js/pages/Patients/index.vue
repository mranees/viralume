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
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination';
import { Eye, Pencil, Trash } from '@lucide/vue';
import { router } from '@inertiajs/vue3';

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
function goToPage(page)
{
    router.get('/patients', { page }, {preserveState: true, preserveScroll: true, only: ['patients']});
}
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
                    <TableHead class="text-center">Actions</TableHead>
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
    <div class="flex justify-end me-4">
        <div class="flex flex-col justify-end gap-6">
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
