<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, Link, router } from "@inertiajs/vue3"
import { Supplier } from '@/types'
import InputError from '@/components/InputError.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    supplier: Supplier,
}>();

const form = useForm({
    name: props.supplier?.name || '',
    email: props.supplier?.email || '',
    phone: props.supplier?.phone || '',
    address: props.supplier?.address || '',
});


const submit = () => {
    if (props.supplier) {
        form.put(route('admin.suppliers.update', props.supplier.id), {
            onSuccess: () => {
                form.reset();
            },
        });
    } else {
        form.post(route('admin.suppliers.store'), {
            onSuccess: () => {
                form.reset();
            },
        })
    }
};
</script>
<template>
    <AppLayout>

        <Head :title="supplier ? 'Modifier un fournisseur' : 'Créer un fournisseur'" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading :title="supplier ? 'Modifier un fournisseur' : 'Créer un fournisseur'" />

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Champ Nom -->
                    <div class="grid gap-2">
                        <Label for="name">Nom</Label>
                        <Input id="name" v-model="form.name" placeholder="Nom du fournisseur" required />
                        <InputError :message="form.errors.name" />
                    </div>

                    <!-- Champ Email -->
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" type="email" v-model="form.email" placeholder="Email du fournisseur" />
                        <InputError :message="form.errors.email" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Champ Téléphone -->
                    <div class="grid gap-2">
                        <Label for="phone">Téléphone</Label>
                        <Input id="phone" v-model="form.phone" placeholder="Téléphone du fournisseur" />
                        <InputError :message="form.errors.phone" />
                    </div>

                    <!-- Champ Adresse -->
                    <div class="grid gap-2">
                        <Label for="address">Adresse</Label>
                        <Input id="address" v-model="form.address" placeholder="Adresse du fournisseur" />
                        <InputError :message="form.errors.address" />
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
