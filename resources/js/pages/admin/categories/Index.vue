<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import Pagination from '@/components/ui/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Category } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    categories: Category[]
}>()

const destroy = (id: Category) => {
    if (confirm('Etes vous sûr de vouloir supprimer ce produit ?')) {
        router.delete(route('admin.categories.destroy', id))
    }
}
</script>
<template>
    <AppLayout>

        <Head title="Toutes les catégories" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading title="Toutes les catégories" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.categories.create')">
                    Ajouter
                </Button>
                <Button type="button" variant="destructive" as="a" :href="route('admin.categories.trash')">
                    Corbeille
                </Button>
            </div>

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
                                <Link :href="route('admin.categories.edit', category)" class="text-btn">
                                Modifier
                                </Link>
                                <button type="button" class="text-btn text-red-600 hover:text-red-800"
                                    @click="destroy(category)">
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
