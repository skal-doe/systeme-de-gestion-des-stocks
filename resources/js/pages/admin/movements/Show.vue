<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Movement, MovementTypeLabels } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    movement: Movement
}>()

const destroy = (id: Movement) => {
    if (confirm('Etes vous sûr de vouloir supprimer ce mouvement ?')) {
        router.delete(route('admin.movements.destroy', id))
    }
}
</script>
<template>
    <AppLayout>

        <Head :title="`${MovementTypeLabels[movement.type]} du fournisseur ${movement.supplier.name}`" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <Heading :title="`${MovementTypeLabels[movement.type]} du fournisseur ${movement.supplier.name}`" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.movements.index')">
                    Retour
                </Button>
                <Button type="button" variant="outline" as="a" :href="route('admin.movements.edit', movement)">
                    Modifier
                </Button>
                <Button type="button" variant="destructive" @click="destroy(movement)">
                    Supprimer
                </Button>
            </div>
            <!--  -->
            <div class="relative overflow-x-auto">
                <div class="divide-y *:py-5">
                    <p><strong>Type:</strong> {{ movement.type }}</p>
                    <p><strong>Produit:</strong> {{ movement.product.name }}
                        <Link :href="route('admin.products.show', movement.product)" class="ml-5 text-btn">
                        Voir le produit
                        </Link>
                    </p>
                    <p><strong>Quantité:</strong> {{ movement.quantity }}</p>
                    <p><strong>Utilisateur:</strong> {{ movement.user.name }}</p>
                    <p><strong>Fournisseur:</strong> {{ movement.supplier.name }}
                        <Link :href="route('admin.suppliers.show', movement.supplier)" class="ml-5 text-btn">
                        Voir le Fournisseur
                        </Link>
                    </p>
                    <p><strong>Reference:</strong> {{ movement.reference }}</p>
                    <p><strong>Notes:</strong><br /> {{ movement.notes }}</p>
                    <p><strong>Date:</strong> {{ new Date(movement.created_at).toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }) }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
