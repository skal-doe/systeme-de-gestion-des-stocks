<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import Pagination from '@/components/ui/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { User } from '@/types';

defineProps<{
    users: User[]
}>();

const destroy = (id: User) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        router.delete(route('admin.users.destroy', id));
    }
};
</script>


<template>
    <AppLayout>
        <Head title="Utilisateurs" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading title="Liste des utilisateurs" />
            <div class="flex items-center gap-5">
                <Button type="button" as="a" :href="route('admin.users.create')">
                    Ajouter
                </Button>
            </div>

            <div class="relative overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rôle</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users.data">
                            <td scope="row">{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role }}</td>
                            <td>{{ new Date(user.created_at).toLocaleDateString('fr-FR', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                            }) }}</td>
                            <td class="space-x-2">
                                <Link :href="route('admin.users.show', user)" class="text-btn">
                                Voir
                                </Link>
                                <Link :href="route('admin.users.edit', user)" class="text-btn">
                                Modifier
                                </Link>
                                <button type="button" class="text-btn text-red-600 hover:text-red-800"
                                    @click="destroy(user)">
                                    supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :items="users" />
        </div>
    </AppLayout>
</template>
