<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { AlertDialogOverlay } from 'reka-ui';
import { ref } from 'vue';

const props = withDefaults(
    defineProps<{
        title?: string;
        description?: string;
        confirmText?: string;
        cancelText?: string;
        processing?: boolean;
    }>(),
    {
        title: 'Are you sure?',
        description: 'This Action cannot be undone.',
        confirmText: 'Delete',
        cancelText: 'Cancel',
        processing: false,
    },
);

const emit = defineEmits<{
    confirm: [];
}>();

// بيتحكم في فتح/قفل الـdialog من هنا، عشان بعد الحذف الناجح نقدر نقفله
// من بره (v-model:open) من غير ما نستنى المستخدم يدوس إلغاء بنفسه.
const open = defineModel<boolean>('open', { default: false });

const handleConfirm = () => {
    emit('confirm');
    // لاحظ: الـdialog مش بيتقفل هنا تلقائيًا — تقفله يدويًا بعد نجاح
    // الـrequest من الصفحة الأب، عشان لو فيه error يفضل مفتوح والمستخدم يشوفه.
};
</script>

<template>
    <AlertDialog v-model:open="open">
        <AlertDialogTrigger as-child>
            <slot />
        </AlertDialogTrigger>

        <AlertDialogOverlay class ="fixed inset-0 bg-black/30 backdrop-blur-sm" />

        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ title }}</AlertDialogTitle>
                <AlertDialogDescription>{{ description }}</AlertDialogDescription>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel :disabled="processing">{{ cancelText }}</AlertDialogCancel>
                <AlertDialogAction as-child>
                    <Button
                        variant="destructive"
                        :disabled="processing"
                        @click="handleConfirm"
                    >
                        {{ processing ? 'Deleting...' : confirmText }}
                    </Button>
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
