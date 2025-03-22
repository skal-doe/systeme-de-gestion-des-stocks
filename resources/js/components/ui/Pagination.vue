<script setup lang="ts">
import { Link } from '@inertiajs/vue3';


defineProps<{
    items: {
        current_page: number,
        prev_page_url: string | null,
        next_page_url: string | null,
        last_page: number,
        links: Array<{ url: string, label: string, active: boolean }>
    }
}>()
</script>
<template>
    <nav class="flex items-center justify-between border-t border-neutral-200 px-4 sm:px-0">
        <!-- Previous Page Link -->
        <div class="-mt-px flex w-0 flex-1">
            <Link :href="items.prev_page_url" v-if="items.current_page > 1"
                class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 font-medium text-neutral-500 hover:border-blue-300 hover:text-blue-700">
            &laquo; Précédent
            </Link>
        </div>

        <!-- Page Links -->
        <div class="hidden md:-mt-px md:flex">
            <Link :href="link.url" v-for="(link, index) in items.links.slice(1, -1)" :key="index" :class="{
                'border-blue-500 bg-blue-50 text-blue-600': link.active,
                'border-transparent text-neutral-500 hover:border-blue-300 hover:text-blue-700': !link.active,
            }" class="inline-flex items-center border-t-2 py-2 px-4 font-medium">
            {{ link.label }}
            </Link>
        </div>

        <!-- Next Page Link -->
        <div class="-mt-px flex w-0 flex-1 justify-end">
            <Link :href="items.next_page_url" v-if="items.current_page < items.last_page"
                class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 font-medium text-neutral-500 hover:border-blue-300 hover:text-blue-700">
            Suivant &raquo;
            </Link>
        </div>
    </nav>
</template>
