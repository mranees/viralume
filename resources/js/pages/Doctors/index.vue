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
import { rand } from '@vueuse/core';
import { router } from '@inertiajs/vue3';


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
function goToPage(page)
{
    router.get('/doctors', { page }, {preserveState: true, preserveScroll: true, only: ['doctors']});
}
</script>

<template>
    <div class="flex flex-col justify-center m-8">
                    {{ console.log(doctors) }}
        <Table class="w-full">
            <TableCaption>A list of Doctors.</TableCaption>
            <TableHeader>
                <TableRow class="uppercase">
                    <TableHead class="text-center">#</TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Phone</TableHead>
                    <TableHead>Specializations</TableHead>
                    <TableHead>Bio</TableHead>
                    <TableHead>Vizita Price</TableHead>
                    <TableHead class="text-center">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="doctor in doctors.data" :key="'doctor-'+doctor.id">
                    <TableCell><img class="w-10 h-10 rounded-full" :src="'https://i.pravatar.cc/300?img='+rand(1,70)" alt="" /></TableCell>
                    <TableCell class="w-[10%]">{{ doctor.name }}</TableCell>
                    <TableCell class="w-[10%]">{{ doctor.email }}</TableCell>
                    <TableCell class="w-[10%]">{{ doctor.phone }}</TableCell>
                    <TableCell class="w-[10%]"><span v-for="spec in doctor.specializations" :key="'spec-'+spec.id">{{ spec.name }}, </span></TableCell>
                    <TableCell class="w-[25%] text-ellipsis">{{ doctor.bio }}</TableCell>
                    <TableCell>{{ doctor.vizita_price }} EGP</TableCell>
                    <TableCell class="flex justify-center gap-2 text-white">
                        <Button><Eye /> Show</Button>
                        <Button class="bg-green-500"><Pencil /> Edit</Button>
                        <Button class="bg-red-500 text-white"><Trash /> Delete</Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
    <div class="flex justify-end me-4">
        <div class="flex flex-col justify-end gap-6">
            <Pagination v-slot="{ page }" :items-per-page="doctors.meta.per_page" :total="doctors.meta.total" :default-page="doctors.meta.current_page" @update:page="goToPage">
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

<style lang="scss" scoped>

</style>
