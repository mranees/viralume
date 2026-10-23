<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import Label from '@/components/ui/label/Label.vue';
import { Form, Head, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { MoveLeft } from '@lucide/vue';
import specializations from '@/routes/specializations';
import type { Specialization } from '@/types/doctor';
import { Textarea } from '@/components/ui/textarea';

const props = defineProps<{
    specialization: Specialization;
}>();

const fields = reactive({
    name: props.specialization.name,
    description: props.specialization.description,
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/',
            },
            {
                title: 'Specializations',
                href: '/specializations',
            },
            {
                title: 'Edit Specialization',
                href: 'specializations/{specialization.id}/edit',
            },
        ],
    },
});
</script>

<template>
    <Head
        variant="small"
        title="Editing Doctor"
        dessciption="pdate the information of specialization"
    />
    <div class="mx-8 flex w-full flex-col items-center justify-center">
        <div class="my-4 w-1/2 text-center">
            <Card>
                <Form
                    v-bind="specializations.update.form(props.specialization.id)"
                    v-slot="{ errors, processing }"
                >
                    <div class="ms-4 flex w-full justify-start">
                        <Link
                            :href="specializations.index()"
                            class="flex items-center gap-2"
                            ><MoveLeft color="white" /> Back</Link
                        >
                    </div>
                    <h1 class="my-4">
                        Edit Specialization "{{ props.specialization.name }}"
                    </h1>
                    <div class="flex flex-col justify-between p-4 gap-2">
                        <div class="flex w-full flex-col gap-2">
                            <Label for="name">Name:</Label>
                            <Input
                                id="name"
                                name="name"
                                v-model="fields.name"
                            />
                            <InputError :message="errors.name" />
                        </div>
                        <div class="flex w-full flex-col gap-2">
                            <Label for="email">Description:</Label>
                            <Textarea
                            id="description"
                            name="description"
                            v-model="fields.description"
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
