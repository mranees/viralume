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
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import ConfirmDeleteDialog from '@/components/ConfirmDeleteDialog.vue';
import { Eye, Pencil, Plus, Search, Trash, X } from '@lucide/vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import patientsroute from '@/routes/patients';
import type { Patient } from '@/types/patient';
import type { Paginated } from '@/types/pagination';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/',
            },
            {
                title: 'Patients',
                href: '/patients',
            },
        ],
    },
});

const props = defineProps<{ patients: Paginated<Patient> }>();

const search = ref<string | null>();
let debounceTimer: ReturnType<typeof setTimeout> | null = null;

watch(search, (value) => {
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        router.get(
            '/patients',
            { search: value },
            { preserveState: true, preserveScroll: true, only: ['patients'] },
        );
    }, 500);
});

function goToPage(page: any) {
    router.get(
        '/patients',
        { page },
        { preserveState: true, preserveScroll: true, only: ['patients'] },
    );
}

// for modals
const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

//for delete modal confomation
const confirmDelete = (patientId: number) => {
    deletingId.value = patientId;

    router.delete(patientsroute.destroy(patientId).url, {
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
        title="List of Patients"
        dessciption="list of all patients in the system"
    />
    <div class="mx-8 my-2 flex justify-between">
        <div class="flex items-center gap-2">
            <Input v-model="search" placeholder="Search..." />
            <div class="-ms-10 flex" v-if="search">
                <X @click="search = null" class="cursor-pointer" />
            </div>
            <div class="-ms-10 flex" v-else><Search /></div>
        </div>
        <div class="flex">
            <Link href="patients/create"
                ><Button><Plus /> New Patient</Button></Link
            >
        </div>
    </div>
    <div class="m-8 flex justify-center">
        <Table class="w-full">
            <TableCaption
                >Show {{ patients.meta.from }} to {{ patients.meta.to }} of
                {{ patients.meta.total }}.</TableCaption
            >
            <TableHeader>
                <TableRow class="uppercase">
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Phone</TableHead>
                    <TableHead>Address</TableHead>
                    <TableHead class="text-center">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow
                    v-for="patient in patients.data"
                    :key="'patient-' + patient.id"
                >
                    <TableCell class="w-[15%]">{{ patient.name }}</TableCell>
                    <TableCell class="w-[15%]">{{ patient.email }}</TableCell>
                    <TableCell class="w-[15%]">{{ patient.phone }}</TableCell>
                    <TableCell>{{ patient.address }}</TableCell>
                    <TableCell class="flex justify-center gap-2 text-white">
                        <Link :href="patientsroute.show(patient.id)" alt="Show"
                            ><Eye class="text-blue-500 hover:text-blue-700"
                        /></Link>
                        <Link :href="patientsroute.edit(patient.id)" alt="Edit"
                            ><Pencil
                                class="text-green-500 hover:text-green-700"
                        /></Link>
                        <ConfirmDeleteDialog
                            v-model="openDialogId"
                            :title="`Delete ${patient.name}?`"
                            description="Are you sure you want to delete this Patient? This action cannot be undone."
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
    <div class="me-4 flex justify-end">
        <div
            v-if="patients.meta.total > patients.meta.per_page"
            class="flex flex-col justify-end gap-6"
        >
            <Pagination
                v-slot="{ page }"
                :items-per-page="patients.meta.per_page"
                :total="patients.meta.total"
                :default-page="patients.meta.current_page"
                @update:page="goToPage"
            >
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
