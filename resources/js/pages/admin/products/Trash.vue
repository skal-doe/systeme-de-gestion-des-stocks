<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Product } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    products: Product[]
}>()

const formatPrice = (price: number) => {
      return new Intl.NumberFormat('fr-FR').format(price);
}


const restoreProduct = (id: Product) => {
  if (confirm("Êtes-vous sûr de vouloir restaurer ce produit ?")) {
    router.post(route('admin.products.restore', id));
  }
};

const forceDeleteProduct = (id: Product) => {
  if (confirm("Êtes-vous sûr de vouloir supprimer définitivement ce produit ?")) {
    router.delete(route('admin.products.force-delete', id));
  }
};

</script>
<template>
    <AppLayout>

        <Head title="Corbeille des produits" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading title="Corbeille des produits" />

            <div class="relative overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                Produits
                            </th>
                            <th scope="col">
                                SKU
                            </th>
                            <th scope="col">
                                Catégorie
                            </th>
                            <th scope="col">
                                Quantité
                            </th>
                            <th scope="col">
                                Prix
                            </th>
                            <th scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in products.data">
                            <th scope="row">
                                {{ product.name }}
                            </th>
                            <td>
                                {{ product.sku }}
                            </td>
                            <td>
                                {{ product.category.name }}
                            </td>
                            <td>
                                {{ product.quantity }}
                            </td>
                            <td>
                                {{ formatPrice(product.price) }} FCFA
                            </td>
                            <td class="space-x-2">
                                <button type="button" class="text-btn"
                                    @click="restoreProduct(product)">
                                    Restaurer
                                </button>
                                <button type="button" class="text-btn text-red-600 hover:text-red-800"
                                    @click="forceDeleteProduct(product)">
                                    supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :items="products" />
        </div>
    </AppLayout>
</template>
