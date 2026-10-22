<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import { Form, Head, Link } from '@inertiajs/vue3';
import { MoveLeft } from '@lucide/vue';
import patients from '@/routes/patients';
import { Patient } from '@/types/patient';

defineProps<{
    patient: Patient;
}>();

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
            {
                title: 'Add New Patient',
                href: '/patients/create',
            },
        ],
    },
});
</script>

<template>
    <Head
        variant="small"
        title="Add New Patient"
        dessciption="adding a new patient to the system"
    />
    <div class="mx-8 flex w-full flex-col items-center justify-center">
        <div class="my-4 w-1/2 text-center">
            <Card>
                <Form
                    v-bind="patients.store.form()"
                    v-slot="{ processing, errors }"
                >
                    <div class="m-4 flex justify-between">
                        <div class="flex justify-start">
                            <Link
                                :href="patients.index()"
                                class="flex items-center gap-2"
                                ><MoveLeft color="white" /> Back</Link
                            >
                        </div>
                        <h1>Add New Patient</h1>
                    </div>
                    <div class="flex justify-between">
                        <div class="m-4 flex w-full flex-col gap-2">
                            <Label for="name">Name:</Label>
                            <Input
                                id="name"
                                name="name"
                                placeholder="Patient Name"
                            />
                            <InputError :message="errors.name" />
                        </div>
                        <div class="m-4 flex w-full flex-col gap-2">
                            <Label for="email">E-mail:</Label>
                            <Input
                                id="email"
                                name="email"
                                placeholder="Patient Email Address"
                            />
                            <InputError :message="errors.email" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="m-4 flex w-full flex-col gap-2">
                            <Label for="phone">Phone Number:</Label>
                            <Input
                                id="phone"
                                name="phone"
                                placeholder="Patient Phone Number"
                            />
                            <InputError :message="errors.phone" />
                        </div>
                        <div class="m-4 flex w-full flex-col gap-2">
                            <Label for="address">Address:</Label>
                            <Input
                                id="address"
                                name="address"
                                placeholder="Patient Address"
                            />
                            <InputError :message="errors.address" />
                        </div>
                    </div>
                    <div class="m-4 flex justify-center gap-4">
                        <Button :disabled="processing" class="w-1/4">{{
                            processing ? 'Saving...' : 'Save'
                        }}</Button>
                        <Link :href="patients.index()" class="w-1/4"
                            ><Button class="w-full">Cancel</Button></Link
                        >
                    </div>
                </Form>
            </Card>
        </div>
    </div>
</template>
