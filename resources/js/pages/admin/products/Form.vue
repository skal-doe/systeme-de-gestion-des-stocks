<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head,useForm, Link, router } from "@inertiajs/vue3"
import { Product, Category } from '@/types'
import InputError from '@/components/InputError.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    product: Product,
    categories: Category,
}>();

const form = useForm({
    name: props.product?.name || '',
    description: props.product?.description || '',
    sku: props.product?.sku || '',
    price: props.product?.price || '',
    quantity: props.product?.quantity || '',
    alert_level: props.product?.alert_level || '',
    category_id: props.product?.category_id || '',
});


const submit = () => {
    if (props.product) {
        form.put(route('admin.products.update', props.product.id), {
            onSuccess: () => {
                form.reset();
            },
        });
    } else {
        form.post(route('admin.products.store'), {
            onSuccess: () => {
                form.reset();
            },
        })
    }
};
</script>
<template>
    <AppLayout>
        <Head :title="product ? 'Modifier un produit' : 'Créer un produit'" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading :title="product ? 'Modifier un produit' : 'Créer un produit'" />

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <!-- Champ Nom -->
                    <div class="grid gap-2">
                        <Label for="name">Nom</Label>
                        <Input
                            id="name"
                            type="text"
                            required
                            autofocus
                            v-model="form.name"
                            placeholder="Nom du produit"
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
                            placeholder="Description du produit"
                        />
                        <InputError :message="form.errors.description" />
                    </div>

                    <!-- Champ SKU -->
                    <div class="grid gap-2">
                        <Label for="sku">SKU</Label>
                        <Input
                            id="sku"
                            type="text"
                            required
                            v-model="form.sku"
                            placeholder="SKU du produit"
                        />
                        <InputError :message="form.errors.sku" />
                    </div>

                    <!-- Champ Prix -->
                    <div class="grid gap-2">
                        <Label for="price">Prix</Label>
                        <Input
                            id="price"
                            type="number"
                            required
                            v-model="form.price"
                            placeholder="Prix du produit"
                        />
                        <InputError :message="form.errors.price" />
                    </div>

                    <!-- Champ Quantité -->
                    <div class="grid gap-2">
                        <Label for="quantity">Quantité</Label>
                        <Input
                            id="quantity"
                            type="number"
                            required
                            v-model="form.quantity"
                            placeholder="Quantité du produit"
                        />
                        <InputError :message="form.errors.quantity" />
                    </div>

                    <!-- Champ Niveau d'alerte -->
                    <div class="grid gap-2">
                        <Label for="alert_level">Niveau d'alerte</Label>
                        <Input
                            id="alert_level"
                            type="number"
                            required
                            v-model="form.alert_level"
                            placeholder="Niveau d'alerte"
                        />
                        <InputError :message="form.errors.alert_level" />
                    </div>

                    <!-- Champ Catégorie -->
                    <div class="grid gap-2">
                        <Label for="category_id">Catégorie</Label>
                        <select
                            id="category_id"
                            v-model="form.category_id"
                            class="p-2 border rounded"
                        >
                            <option value="" disabled>Sélectionnez une catégorie</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.category_id" />
                    </div>

                    <!-- Bouton de soumission -->
                    <Button type="submit" class="mt-4 w-full" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        {{ product ? 'Mettre à jour' : 'Créer' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
