<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import InputError from '@/components/InputError.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/Input';
import { Label } from '@/components/ui/Label';
import AppLayout from '@/layouts/AppLayout.vue';
import { User } from '@/types';

const props = defineProps<{
    user: User;
    roles: Object[];
}>();

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    role: props.user?.role || 'manager',
    password: '',
    password_confirmation: ''
});

const submit = () => {
    if (props.user) {
        form.put(route('admin.users.update', props.user.id), {
            onSuccess: () => {
                form.reset();
            },
        });
    } else {
        form.post(route('admin.users.store'), {
            onSuccess: () => {
                form.reset();
            },
        })
    }
};
</script>


<template>
    <AppLayout>

        <Head :title="user ? 'Modifier un utilisateur' : 'Créer un utilisateur'" />

        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading :title="user ? 'Modifier l\'utilisateur' : 'Créer un nouvel utilisateur'" />

            <form @submit.prevent="submit" class="space-y-5">
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Champ nom -->
                    <div class="grid gap-2">
                        <Label for="name">Nom</Label>
                        <Input id="name" v-model="form.name" required />
                        <InputError :message="form.errors.name" />
                    </div>

                    <!-- Champ email -->
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" v-model="form.email" type="email" required />
                        <InputError :message="form.errors.email" />
                    </div>
                </div>

                <!-- Champ rôle -->
                <div class="grid gap-2">
                    <Label for="role">Rôle</Label>
                    <select id="role" v-model="form.role" required>
                        <option v-for="(role, index) in roles" :key="index" :value="role.value">
                            {{ role.label }}
                        </option>
                    </select>
                    <InputError :message="form.errors.role" />
                </div>

                <div class="grid md:grid-cols-2 gap-4">

                    <!-- Champ mot de passe -->
                    <div class="grid gap-2">
                        <Label for="password">
                            {{
                                user ? 'Nouveau mot de passe (laisser vide pour ne pas changer)' : 'Mot de passe'
                            }}
                        </Label>
                        <Input id="password" v-model="form.password" type="password" :required="!user" />
                        <InputError :message="form.errors.password" />
                    </div>

                    <!-- Champ confirmation du mot de passe -->
                    <div class="grid gap-2">
                        <Label for="password_confirmation">Confirmer le mot de passe</Label>
                        <Input id="password_confirmation" v-model="form.password_confirmation" type="password"
                            :required="!user" />
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <Button type="submit" :disabled="form.processing">
                    {{ supplier ? 'Mettre à jour' : 'Créer' }}
                </Button>
            </form>
        </div>
    </AppLayout>
</template>
