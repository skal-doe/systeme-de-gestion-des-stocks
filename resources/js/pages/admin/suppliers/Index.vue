<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import Pagination from '@/components/ui/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Supplier } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    suppliers: Supplier[]
}>()

const destroy = (id: supplier) => {
    if (confirm('Etes vous sûr de vouloir supprimer ce fournisseur ?')) {
        router.delete(route('admin.suppliers.destroy', id))
    }
}
</script>
<template>
    <AppLayout>

        <Head title="Liste des fournisseurs" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading title="Liste des fournisseurs" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.suppliers.create')">
                    Ajouter
                </Button>
                <Button type="button" variant="destructive" as="a" :href="route('admin.suppliers.trash')">
                    Corbeille
                </Button>
            </div>

            <div class="relative overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(supplier, index) in suppliers.data">
                            <td scope="row">{{ supplier.name }}</td>
                            <td>{{ supplier.email }}</td>
                            <td>{{ supplier.phone }}</td>
                            <td>{{ supplier.address }}</td>
                            <td class="space-x-2">
                                <Link :href="route('admin.suppliers.show', supplier)" class="text-btn">
                                Voir
                                </Link>
                                <Link :href="route('admin.suppliers.edit', supplier)" class="text-btn">
                                Modifier
                                </Link>
                                <button type="button" class="text-btn text-red-600 hover:text-red-800"
                                    @click="destroy(supplier)">
                                    supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :items="suppliers" />
        </div>
    </AppLayout>
</template>
