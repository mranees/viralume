<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Switch from '@/components/ui/switch/Switch.vue';
import { Textarea } from '@/components/ui/textarea';
import patients from '@/routes/patients';
import { Patient } from '@/types';
import { Form } from '@inertiajs/vue3';

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
const props = defineProps<{
    specialities: Array<{ id: number; name: string }>,
    patient: Patient | undefined,
}>();
</script>

<template>
    <div class=" w-full flex flex-col justify-center items-center mx-8 ">
        <div class="w-1/2 my-4 text-center">
            <Card>
                <Form v-bind="patients.store.form()">
                    <h1>Add New Doctor</h1>
                    <div class="flex items-center justify-center m-auto w-48 h-48 rounded-full border border-blue-500">Profile Image</div>
                    <div class="flex justify-between">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="name">Name:</Label>
                            <Input id="name" name="name" :defaultValue="props.patient?.name || ''" placeholder="Doctor Name" />
                        </div>
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="email">E-mail:</Label>
                            <Input id="email" name="email" :defaultValue="props.patient?.email || ''" placeholder="Doctor Email Address" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="phone">Phone Number:</Label>
                            <Input id="phone" name="phone" :defaultValue="props.patient?.phone || ''" placeholder="Doctor Phone Number" />
                        </div>
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="vizita_price">Vizita Price:</Label>
                            <Input id="vizita_price" name="vizita_price" :defaultValue="props.patient?.vizita_price || 0" placeholder="Doctor Vizita Price" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 m-4">
                        <Label for="bio">Bio:</Label>
                        <Textarea id="bio" name="bio" :defaultValue="props.patient?.bio || ''" placeholder="Doctor Short Biography" />
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="profile_image">Profile Image:</Label>
                            <Input id="profile_image" name="profile_image" :defaultValue="props.patient?.profile_image || ''" placeholder="Doctor Profile Image" />
                        </div>
                        <div class="w-48 flex items-center gap-2 m-4">
                            <Label for="is_active">Doctor Status:</Label>
                            <Switch id="is_active" name="is_active" :defaultValue="props.patient?.is_active ?? false" placeholder="Doctor Status" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 m-4">
                        <Label>Doctor Specializations:</Label>
                        <div class="grid grid-cols-3">
                            <div v-for="spec in props.specialities" :key="'spec'+spec.id" class="flex items-center gap-2 m-4">
                                <Checkbox  id="{{ spec.id }}" />
                                <Label for="{{ spec.id }}">{{ spec.name }}</Label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center m-4 gap-4">
                        <Button class="w-1/4">Save</Button>
                        <Button class="w-1/4">Reset</Button>
                    </div>
                </Form>
            </Card>
        </div>
    </div>
</template>
