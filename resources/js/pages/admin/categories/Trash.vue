<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Category } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    categories: Category[]
}>()

const formatPrice = (price: number) => {
      return new Intl.NumberFormat('fr-FR').format(price);
}


const restorecategory = (id: Category) => {
  if (confirm("Êtes-vous sûr de vouloir restaurer ce produit ?")) {
    router.post(route('admin.categories.restore', id));
  }
};

const forceDeletecategory = (id: Category) => {
  if (confirm("Êtes-vous sûr de vouloir supprimer définitivement ce produit ?")) {
    router.delete(route('admin.categories.force-delete', id));
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
                                Nom
                            </th>
                            <th scope="col">
                                Description
                            </th>
                            <th scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, index) in categories.data">
                            <th scope="row">
                                {{ category.name }}
                            </th>
                            <td>
                                {{ category.description }}
                            </td>
                            <td class="space-x-2">
                                <button type="button" class="text-btn"
                                    @click="restorecategory(category)">
                                    Restaurer
                                </button>
                                <button type="button" class="text-btn text-red-600 hover:text-red-800"
                                    @click="forceDeletecategory(category)">
                                    supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :items="categories" />
        </div>
    </AppLayout>
</template>
