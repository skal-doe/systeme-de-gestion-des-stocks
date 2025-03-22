<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import Pagination from '@/components/ui/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Movement } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    movements: Movement[]
}>()

const destroy = (id: Movement) => {
    if (confirm('Etes vous sûr de vouloir supprimer ce produit ?')) {
        router.delete(route('admin.movements.destroy', id))
    }
}
</script>
<template>
    <AppLayout>

        <Head title="Liste des mouvements" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading title="Liste des mouvements" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.movements.create')">
                    Ajouter
                </Button>
            </div>

            <div class="relative overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                Type
                            </th>
                            <th scope="col">
                                Produit
                            </th>
                            <th scope="col">
                                Quantité
                            </th>
                            <th scope="col">
                                Utilisateur
                            </th>
                            <th scope="col">
                                Fournisseur
                            </th>
                            <th scope="col">
                                Date
                            </th>
                            <th scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(movement, index) in movements.data">
                            <th scope="row">
                                {{ movement.type }}
                            </th>
                            <td>
                                {{ movement.product.name }}
                            </td>
                            <td>
                                {{ movement.quantity }}
                            </td>
                            <td>
                                {{ movement.user.name }}
                            </td>
                            <td>
                                {{ movement.supplier?.name }}
                            </td>
                            <td>
                                {{ new Date(movement.date).toLocaleDateString('fr-FR') }}
                            </td>
                            <td class="space-x-2">
                                <Link :href="route('admin.movements.edit', movement)" class="text-btn">
                                Modifier
                                </Link>
                                <button type="button" class="text-btn text-red-600 hover:text-red-800"
                                    @click="destroy(movement)">
                                    supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :items="movements" />
        </div>
    </AppLayout>
</template>
