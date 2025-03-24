<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Supplier } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    supplier: Supplier
}>()

const destroy = (id: Supplier) => {
    if (confirm('Etes vous sûr de vouloir supprimer ce fournisseur ?')) {
        router.delete(route('admin.suppliers.destroy', id))
    }
}
</script>
<template>
    <AppLayout>

        <Head :title="supplier.name" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <Heading :title="supplier.name" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.suppliers.index')">
                    Retour
                </Button>
                <Button type="button" variant="outline" as="a" :href="route('admin.suppliers.edit', supplier)">
                    Modifier
                </Button>
                <Button type="button" variant="destructive" @click="destroy(supplier)">
                    Supprimer
                </Button>
            </div>
            <!--  -->
            <div class="relative overflow-x-auto">
                <div class="divide-y *:py-5">
                    <p><strong>Nom:</strong> {{ supplier.name }}</p>
                    <p><strong>Email:</strong> {{ supplier.email }}</p>
                    <p><strong>Téléphone:</strong> {{ supplier.phone }}</p>
                    <p><strong>Adresse:</strong> {{ supplier.address }}</p>
                    <p><strong>Date d'ajout:</strong> {{ new Date(supplier.created_at).toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }) }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
