<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Supplier } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    suppliers: Supplier[]
}>()


const restoreSupplier = (id: Supplier) => {
  if (confirm("Êtes-vous sûr de vouloir restaurer ce fournisseur ?")) {
    router.post(route('admin.suppliers.restore', id));
  }
};

const forceDeleteSupplier = (id: Supplier) => {
  if (confirm("Êtes-vous sûr de vouloir supprimer définitivement ce fournisseur ?")) {
    router.delete(route('admin.suppliers.force-delete', id));
  }
};

</script>
<template>
    <AppLayout>

        <Head title="Corbeille des fournisseurs" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading title="Corbeille des fournisseurs" />

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
                                <button type="button" class="text-btn"
                                    @click="restoreSupplier(supplier)">
                                    Restaurer
                                </button>
                                <button type="button" class="text-btn text-red-600 hover:text-red-800"
                                    @click="forceDeleteSupplier(supplier)">
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
