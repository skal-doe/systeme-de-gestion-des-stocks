<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Product } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    product: Product
}>()

const destroy = (id: Product) => {
    if (confirm('Etes vous sûr de vouloir supprimer ce produit ?')) {
        router.delete(route('admin.products.destroy', id))
    }
}
</script>
<template>
    <AppLayout>

        <Head :title="product.name" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <Heading :title="product.name" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.products.index')">
                    Retour
                </Button>
                <Button type="button" variant="outline" as="a" :href="route('admin.products.edit', product)">
                    Modifier
                </Button>
                <Button type="button" variant="destructive" @click="destroy(product)">
                    Supprimer
                </Button>
            </div>

            <div class="relative overflow-x-auto">
                <div class="divide-y *:py-5">
                    <p><strong>Nom:</strong> {{ product.name }}</p>
                    <p><strong>Description:</strong><br /> {{ product.description }}</p>
                    <p><strong>Prix:</strong> {{ new Intl.NumberFormat('fr-FR').format(product.price) }} FCFA</p>
                    <p><strong>Quantité:</strong> {{ product.quantity }}</p>
                    <p><strong>Catégorie:</strong> {{ product.category.name }}</p>
                    <p><strong>SKU:</strong> {{ product.sku }}</p>
                    <p><strong>Niveau d'alert:</strong> {{ product.alert_level }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
