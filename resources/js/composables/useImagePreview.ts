// resources/js/composables/useImagePreview.ts
import storage from '@/routes/storage'
import { onBeforeUnmount, ref } from 'vue'

export function useImagePreview() {

    const MAX_SIZE = 2048 * 1024 // 2MB
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp']
    const preview = ref<string | null>(storage.local.url('doctor_default_profile_image.jpg'))

    const fileInput = ref<HTMLInputElement | null>(null)
    const imageError = ref<string | null>(null)

  function clear() {
    if (preview.value) URL.revokeObjectURL(preview.value) // تحرير الذاكرة
    preview.value = storage.local.url('doctor_default_profile_image.jpg')
  }

  function setFile(file: File | null | undefined) {
    clear()
    if (file) preview.value = URL.createObjectURL(file)
  }

  onBeforeUnmount(clear)
  function onFileChange(e: Event) {
  const input = e.target as HTMLInputElement
  const file = input.files?.[0]

  imageError.value = null
  input.setCustomValidity('')

  if (!file) return clear()

  if (!ALLOWED_TYPES.includes(file.type)) {
    imageError.value = 'must be valid image JPG or PNG or Webbp'
  } else if (file.size > MAX_SIZE) {
    imageError.value = `image size is ${(file.size / 1024 / 1024).toFixed(1)}MB، and it must be less than 2MB`
  }

  if (imageError.value) {
    input.value = ''   // يفضّي الاختيار
    return clear()     // يشيل الـ preview
  }

  setFile(file)
}

  return { preview, fileInput, imageError, onFileChange , setFile, clear }
}
