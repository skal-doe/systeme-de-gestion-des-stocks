<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head,useForm, Link, router } from "@inertiajs/vue3"
import { Category } from '@/types'
import InputError from '@/components/InputError.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    category: Category,
}>();

const form = useForm({
    name: props.category?.name || '',
    description: props.category?.description || '',
    sku: props.category?.sku || '',
    price: props.category?.price || '',
    quantity: props.category?.quantity || '',
    alert_level: props.category?.alert_level || '',
    category_id: props.category?.category_id || '',
});


const submit = () => {
    if (props.category) {
        form.put(route('admin.categories.update', props.category.id), {
            onSuccess: () => {
                form.reset();
            },
        });
    } else {
        form.post(route('admin.categories.store'), {
            onSuccess: () => {
                form.reset();
            },
        })
    }
};
</script>
<template>
   <AppLayout>
    <Head :title="category ? 'Modifier une catégorie' : 'Créer une catégorie'" />
    <div class="flex h-full flex-col gap-4 rounded-xl p-4">
      <p class="alert success" v-if="$page.props.flash.message">
        {{ $page.props.flash.message }}
      </p>
      <Heading :title="category ? 'Modifier une catégorie' : 'Créer une catégorie'" />

      <form @submit.prevent="submit" class="flex flex-col gap-6">
        <!-- Champ Nom -->
        <div class="grid gap-2">
          <Label for="name">Nom</Label>
          <Input
            id="name"
            type="text"
            required
            v-model="form.name"
            placeholder="Nom de la catégorie"
          />
          <InputError :message="form.errors.name" />
        </div>

        <!-- Champ Description -->
        <div class="grid gap-2">
          <Label for="description">Description</Label>
          <Input
            id="description"
            type="text"
            v-model="form.description"
            placeholder="Description de la catégorie"
          />
          <InputError :message="form.errors.description" />
        </div>

        <!-- Bouton de soumission -->
        <Button type="submit" class="mt-4 w-full" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
          {{ category ? 'Mettre à jour' : 'Créer' }}
        </Button>
      </form>
    </div>
  </AppLayout>
</template>
