<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Product } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    product: Product
}>()

</script>
<template>
    <AppLayout>

        <Head title="Tous les produits" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <Heading title="Tous les produits" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.products.index')">
                    Retour
                </Button>
            </div>

            <div class="relative overflow-x-auto">
            </div>

        </div>
    </AppLayout>
</template>
