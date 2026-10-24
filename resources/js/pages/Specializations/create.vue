<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import { Form, Head, Link } from '@inertiajs/vue3';
import { MoveLeft } from '@lucide/vue';
import specializations from '@/routes/specializations';
import { Specialization } from '@/types/doctor';
import { Textarea } from '@/components/ui/textarea';

defineProps<{
    specialization: Specialization;
}>();

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
            {
                title: 'Add New Specialization',
                href: '/specializations/create',
            },
        ],
    },
});
</script>

<template>
    <Head
        variant="small"
        title="Add New Specialization"
        dessciption="adding a new specialization to the system"
    />
    <div class="mx-8 flex w-full flex-col items-center justify-center">
        <div class="my-4 w-1/2 text-center">
            <Card>
                <Form
                    v-bind="specializations.store.form()"
                    v-slot="{ processing, errors }"
                >
                    <div class="m-4 flex justify-between">
                        <div class="flex justify-start">
                            <Link
                                :href="specializations.index()"
                                class="flex items-center gap-2"
                                ><MoveLeft color="white" /> Back</Link
                            >
                        </div>
                        <h1>Add New Specialization</h1>
                    </div>
                    <div class="flex flex-col justify-between gap-2 p-4">
                        <div class="flex w-full flex-col gap-2">
                            <Label for="name">Name:</Label>
                            <Input
                                id="name"
                                name="name"
                                placeholder="Specialization Name"
                            />
                            <InputError :message="errors.name" />
                        </div>
                        <div class="flex w-full flex-col gap-2">
                            <Label for="email">Description:</Label>
                            <Textarea
                                id="description"
                                name="description"
                                placeholder="Specialization Short Description"
                            />
                            <InputError :message="errors.description" />
                        </div>
                    </div>
                    <div class="m-4 flex justify-center gap-4">
                        <Button :disabled="processing" class="w-1/4">{{
                            processing ? 'Saving...' : 'Save'
                        }}</Button>
                        <Link :href="specializations.index()" class="w-1/4"
                            ><Button class="w-full">Cancel</Button></Link
                        >
                    </div>
                </Form>
            </Card>
        </div>
    </div>
</template>
