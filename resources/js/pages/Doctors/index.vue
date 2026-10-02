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
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import ConfirmDeleteDialog from '@/components/ConfirmDeleteDialog.vue';
import Button from '@/components/ui/button/Button.vue';
import { Eye, Pencil, Plus, Search, Trash, Trash2 } from '@lucide/vue';
import { rand } from '@vueuse/core';
import { Link, router } from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import doctorsroute from '@/routes/doctors';
import { ref, watch } from 'vue';

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
        ],
    },
});

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
    doctors: Doctor[],
}>();

const search = ref<string | null>();
let debounceTimer: ReturnType<typeof setTimeout> | null = null;

watch(search, (value)=>{
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
    router.get('/doctors', { search: value }, {preserveState: true, preserveScroll: true, only: ['doctors']});
    }
    , 500);
})

// for pagination
function goToPage(page: any)
{
    router.get('/doctors', { page }, {preserveState: true, preserveScroll: true, only: ['doctors']});
}

// for modals
const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

//for delete modal confomation
const confirmDelete = (doctorId: number) => {
    deletingId.value = doctorId;

    router.delete(doctorsroute.destroy(doctorId).url, {
        preserveScroll: true,
        onSuccess: () => {
            openDialogId.value = null;
        },
        onFinish: () => {
            deletingId.value = null;
        },
    });
};

console.log(JSON.stringify(props.doctors));
</script>

<template>

    <div class="flex justify-between mx-8 my-2">
        <div class="flex gap-2 items-center"><Input v-model="search" placeholder="Search..." /><Search /></div>
        <div class="flex">
            <Link href="doctors/create"><Button><Plus /> New Doctor</Button></Link>
        </div>
    </div>
    <div class="flex flex-col justify-center mx-8 ">
        <Table class="w-full">
            <TableCaption>Show {{ doctors.meta.from }} to {{ doctors.meta.to }} of {{ doctors.meta.total }}.</TableCaption>
            <TableHeader>
                <TableRow class="uppercase">
                    <TableHead class="text-center">#</TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Phone</TableHead>
                    <TableHead>Specializations</TableHead>
                    <TableHead>Vizita Price</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead class="text-center">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="doctor in doctors.data" :key="'doctor-'+doctor.id">
                    <TableCell class="w-25"><img class="w-10 h-10 rounded-full" :src="'https://i.pravatar.cc/300?img='+rand(1,70)" alt="" /></TableCell>
                    <TableCell class="w-[15%]">{{ doctor.name }}</TableCell>
                    <TableCell class="w-[15%]">{{ doctor.email }}</TableCell>
                    <TableCell class="w-[15%]">{{ doctor.phone }}</TableCell>
                    <TableCell class="w-[15%]"><span v-for="spec in doctor.specializations" :key="'spec-'+spec.id">{{ spec.name }}, </span></TableCell>
                    <TableCell class="w-[15%]">{{ doctor.vizita_price }} EGP</TableCell>
                    <TableCell class="w-[15%]">{{ doctor.is_active ? 'Active' : 'Inactive' }}</TableCell>
                    <TableCell class="flex justify-center items-center gap-4 text-white">
                        <Link :href="doctorsroute.show(doctor.id)" alt="Show"><Eye class="text-blue-500 hover:text-blue-700" /></Link>
                        <Link :href="doctorsroute.edit(doctor.id)" alt="Edit"><Pencil class="text-green-500 hover:text-green-700" /></Link>
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
    <div v-if="doctors.meta.total > doctors.meta.per_page" class="flex justify-end items-center me-4">
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
