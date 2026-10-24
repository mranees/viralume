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
import specializationsroute from '@/routes/specializations';
import type { Specialization } from '@/types/doctor';
import type { Paginated } from '@/types/pagination';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/dashboard',
            },
            {
                title: 'Specializations',
                href: '/specializations',
            },
        ],
    },
});

const props = defineProps<{ specializations: Paginated<Specialization> }>();

const search = ref<string | null>();
let debounceTimer: ReturnType<typeof setTimeout> | null = null;

watch(search, (value) => {
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        router.get(
            '/specializations',
            { search: value },
            {
                preserveState: true,
                preserveScroll: true,
                only: ['specializations'],
            },
        );
    }, 500);
});

function goToPage(page: any) {
    router.get(
        '/specializations',
        { page },
        {
            preserveState: true,
            preserveScroll: true,
            only: ['specializations'],
        },
    );
}

// for modals
const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

//for delete modal confomation
const confirmDelete = (specializationId: number) => {
    deletingId.value = specializationId;

    router.delete(specializationsroute.destroy(specializationId).url, {
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
        title="List of Specializations"
        dessciption="list of all specializations in the system"
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
            <Link href="specializations/create"
                ><Button><Plus /> New Specialization</Button></Link
            >
        </div>
    </div>
    <div class="m-8 flex justify-center">
        <Table class="w-full">
            <TableCaption
                >Show {{ specializations.meta.from }} to
                {{ specializations.meta.to }} of
                {{ specializations.meta.total }}.</TableCaption
            >
            <TableHeader>
                <TableRow class="uppercase">
                    <TableHead>Name</TableHead>
                    <TableHead>Description</TableHead>
                    <TableHead class="text-center">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow
                    v-for="specialization in specializations.data"
                    :key="'specialization-' + specialization.id"
                >
                    <TableCell class="w-[15%]">{{
                        specialization.name
                    }}</TableCell>
                    <TableCell class="">{{
                        specialization.description
                    }}</TableCell>
                    <TableCell class="flex justify-center gap-2 text-white">
                        <Link
                            :href="specializationsroute.show(specialization.id)"
                            alt="Show"
                            ><Eye class="text-blue-500 hover:text-blue-700"
                        /></Link>
                        <Link
                            :href="specializationsroute.edit(specialization.id)"
                            alt="Edit"
                            ><Pencil
                                class="text-green-500 hover:text-green-700"
                        /></Link>
                        <ConfirmDeleteDialog
                            v-model="openDialogId"
                            :title="`Delete ${specialization.name}?`"
                            description="Are you sure you want to delete this Specialization? This action cannot be undone."
                            :processing="deletingId === specialization.id"
                            @confirm="confirmDelete(specialization.id)"
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
            v-if="specializations.meta.total > specializations.meta.per_page"
            class="flex flex-col justify-end gap-6"
        >
            <Pagination
                v-slot="{ page }"
                :items-per-page="specializations.meta.per_page"
                :total="specializations.meta.total"
                :default-page="specializations.meta.current_page"
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
