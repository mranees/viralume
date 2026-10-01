<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import Label from '@/components/ui/label/Label.vue';
import Switch from '@/components/ui/switch/Switch.vue';
import { Textarea } from '@/components/ui/textarea';
import doctors from '@/routes/doctors';
import { Form, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { CheckboxGroupRoot } from 'reka-ui';
import { MoveLeft } from '@lucide/vue';

defineProps<{
    specializations: Array<{ id: number; name: string }>,
}>();

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
                title: 'Add New Doctor',
                href: '/doctors/create',
            },
        ],
    },
});

const is_active = ref(true);

const logdata = (data: Record<string, any>) => {
    console.log(data);
    return data;
};

</script>

<template>
    <div class=" w-full flex flex-col justify-center items-center mx-8 ">
        <div class="w-1/2 my-4 text-center">
            <Card>
                <Form v-bind="doctors.store.form()" :transform="logdata" v-slot="{errors, processing}">
                    <div class="flex justify-start w-full ms-4">
                        <Link :href="doctors.index()" class="flex items-center gap-2"><MoveLeft color="white" /> Back</Link>
                    </div>
                    <h1>Add New Doctor</h1>
                    <div class="flex items-center justify-center m-auto w-48 h-48 rounded-full border border-blue-500">Profile Image</div>
                    <div class="flex justify-between">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="name">Name:</Label>
                            <Input id="name" name="name" placeholder="Doctor Name" />
                            <InputError :message="errors.name" />
                        </div>
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="email">E-mail:</Label>
                            <Input id="email" name="email" placeholder="Doctor Email Address" />
                            <InputError :message="errors.email" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="phone">Phone Number:</Label>
                            <Input id="phone" name="phone" placeholder="Doctor Phone Number" />
                            <InputError :message="errors.phone" />
                        </div>
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="vizita_price">Vizita Price:</Label>
                            <Input id="vizita_price" name="vizita_price" placeholder="Doctor Vizita Price" />
                            <InputError :message="errors.vizita_price" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 m-4">
                        <Label for="bio">Bio:</Label>
                        <Textarea id="bio" name="bio" placeholder="Doctor Short Biography" />
                        <InputError :message="errors.bio" />
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="w-full flex flex-col gap-2 m-4">
                            <Label for="profile_image">Profile Image:</Label>
                            <Input id="profile_image" name="profile_image" placeholder="Doctor Profile Image" />
                            <InputError :message="errors.profile_image" />
                        </div>
                        <div class="flex flex-col">
                            <div class="w-48 flex items-center gap-2 m-4">
                                <Label for="is_active">Doctor Status:</Label>
                                <input type="hidden" name="is_active" :value="true ? 1 : 0" />
                                <Switch id="is_active" v-model="is_active" :trueValue="true" :falseValue="false" />
                            </div>
                            <InputError :message="errors.is_active" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 m-4">
                        <Label>Doctor Specializations:</Label>
                        <CheckboxGroupRoot id="specialities" name="specializations">
                            <div class="grid grid-cols-3">
                                <div v-for="spec in specializations" :key="'spec'+spec.id" class="flex items-center gap-2 m-4">
                                    <Label><Checkbox name="specializations[]" :value="spec.id" />{{ spec.name }}</Label>
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
