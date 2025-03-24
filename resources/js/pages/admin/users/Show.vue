<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { User } from '@/types';
import { Head, Link, router } from "@inertiajs/vue3"

defineProps<{
    user: User
}>()

const destroy = (id: User) => {
    if (confirm('Etes vous sûr de vouloir supprimer ce fournisseur ?')) {
        router.delete(route('admin.users.destroy', id))
    }
}
</script>
<template>
    <AppLayout>

        <Head :title="user.name" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <Heading :title="user.name" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.users.index')">
                    Retour
                </Button>
                <Button type="button" variant="outline" as="a" :href="route('admin.users.edit', user)">
                    Modifier
                </Button>
                <Button type="button" variant="destructive" @click="destroy(user)">
                    Supprimer
                </Button>
            </div>
            <!--  -->
            <div class="relative overflow-x-auto">
                <div class="divide-y *:py-5">
                    <p><strong>Nom:</strong> {{ user.name }}</p>
                    <p><strong>Email:</strong> {{ user.email }}</p>
                    <p><strong>Rôle:</strong> {{ user.role }}</p>
                    <p><strong>Date d'ajout:</strong> {{ new Date(user.created_at).toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }) }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
