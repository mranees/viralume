<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import Label from '@/components/ui/label/Label.vue';
import Switch from '@/components/ui/switch/Switch.vue';
import { Textarea } from '@/components/ui/textarea';
import { Form, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, reactive, ref, watch } from 'vue';
import { CheckboxGroupRoot } from 'reka-ui';
import doctors from '@/routes/doctors';
import { MoveLeft } from '@lucide/vue';

interface Specializations {
    id: number;
    name: string;
}
interface Doctor {
    id: number;
    name: string;
    email: string;
    phone: string;
    vizita_price: number;
    bio: string;
    profile_image: string;
    is_active: boolean;
    specializations: Specializations[];
}

const props = defineProps<{
    specializations: Specializations[];
    doctor: Doctor,
}>();

const fields = reactive({
    name: props.doctor.name,
    email: props.doctor.email,
    phone: props.doctor.phone,
    vizita_price: props.doctor.vizita_price,
    bio: props.doctor.bio,
    profile_image: props.doctor.profile_image,
    is_active: props.doctor.is_active,
    specializations: props.doctor.specializations.map((spec) => spec.id),
})

const isActive = ref(props.doctor.is_active);
const selectedSpeciallizations = ref<number[]>(

    props.doctor.specializations.map((spec) => spec.id),
);

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
console.log(JSON.stringify(props.specializations));
console.log(JSON.stringify(props.doctor));

</script>

<template>
    <div class=" w-full flex flex-col justify-center items-center mx-8 ">
        <div class="w-1/2 my-4 text-center">
            <Card>
                <Form v-bind="doctors.update.form(props.doctor.id)" v-slot="{errors, processing}">
                    <div class="flex justify-start w-full ms-4">
                        <Link :href="doctors.index()" class="flex items-center gap-2"><MoveLeft color="white" /> Back</Link>
                    </div>
                    <h1 class="my-4">Edit Doctor "{{ props.doctor.name }}"</h1>
                    <img :src="props.doctor.profile_image" class="flex items-center justify-center mx-auto w-48 h-48 rounded-full border border-blue-500" />
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
                            <Label for="vizita_price">Vizita Price:</Label>
                            <Input id="vizita_price" name="vizita_price" v-model="fields.vizita_price" />
                            <InputError :message="errors.vizita_price" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 m-4">
                        <Label for="bio">Bio:</Label>
                        <Textarea id="bio" name="bio" v-model="fields.bio" />
                        <InputError :message="errors.bio" />
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="profile_image">Profile Image:</Label>
                            <Input id="profile_image" name="profile_image" v-model="fields.profile_image" />
                            <InputError :message="errors.profile_image" />
                        </div>
                        <div class="flex flex-col">
                            <div class="w-48 flex items-center gap-2 m-4">
                                <Label for="is_active">Doctor Status:</Label>
                                <input type="hidden" name="is_active" :value="fields.is_active ? 1 : 0" />
                                <Switch id="is_active" v-model="fields.is_active" :trueValue="true" :falseValue="false" />
                            </div>
                            <InputError :message="errors.is_active" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 m-4">
                        <Label>Doctor Specializations:</Label>
                        <CheckboxGroupRoot id="specializations" name="specializations" v-model="selectedSpeciallizations">
                            <div class="grid grid-cols-3">
                                <div v-for="spec in props.specializations" :key="'spec'+spec.id" class="flex items-center gap-2 m-4">
                                    <Label><Checkbox :value="spec.id"  />{{ spec.name }}</Label>
                                </div>
                            </div>
                        </CheckboxGroupRoot>
                            <InputError :message="errors.specializations" />
                    </div>
                    <div class="flex justify-center m-4 gap-4">
                        <Button :disabled="processing" class="w-1/4">{{ processing ? 'Saving...' : 'Save' }}</Button>
                        <Link :href="doctors.index()" class="w-1/4"><Button class="w-full">Cancel</Button></Link>
                    </div>
                </Form>
            </Card>
        </div>
    </div>
</template>
