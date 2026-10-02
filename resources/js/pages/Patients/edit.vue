<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import Label from '@/components/ui/label/Label.vue';
import { Form, Link, useForm, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { MoveLeft } from '@lucide/vue';
import patients from '@/routes/patients';

interface Patient {
    id: number;
    name: string;
    email: string;
    phone: string;
    address: string;
}

const props = defineProps<{
    patient: Patient;
}>();

const fields = reactive({
    name: props.patient.name,
    email: props.patient.email,
    phone: props.patient.phone,
    address: props.patient.address,
})

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
            {
                title: 'Edit Doctor',
                href: 'doctors/{doctor.id}/edit',
            },
        ],
    },
});

const logdata = (data: Record<string, any>) => {
    console.log(data);
    return data;
};

</script>

<template>
    <div class=" w-full flex flex-col justify-center items-center mx-8 ">
        <div class="w-1/2 my-4 text-center">
            <Card>
                <Form v-bind="patients.update.form(props.patient.id)" v-slot="{errors, processing}">
                    <div class="flex justify-start w-full ms-4">
                        <Link :href="patients.index()" class="flex items-center gap-2"><MoveLeft color="white" /> Back</Link>
                    </div>
                    <h1 class="my-4">Edit Patient "{{ props.patient.name }}"</h1>
                    <div class="flex justify-between">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="name">Name:</Label>
                            <Input id="name" name="name" v-model="fields.name" />
                            <InputError :message="errors.name" />
                        </div>
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="email">E-mail:</Label>
                            <Input id="email" name="email" v-model="fields.email" />
                            <InputError :message="errors.email" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="phone">Phone Number:</Label>
                            <Input id="phone" name="phone" v-model="fields.phone" />
                            <InputError :message="errors.phone" />
                        </div>
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="address">Address:</Label>
                            <Input id="address" name="address" v-model="fields.address" />
                            <InputError :message="errors.address" />
                        </div>
                    </div>
                    <div class="flex justify-center m-4 gap-4">
                        <Button :disabled="processing" class="w-1/4">{{ processing ? 'Saving...' : 'Save' }}</Button>
                        <Link :href="patients.index()" class="w-1/4"><Button class="w-full">Cancel</Button></Link>
                    </div>
                </Form>
            </Card>
        </div>
    </div>
</template>
