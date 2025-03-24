<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, Link, router } from "@inertiajs/vue3"
import { User, Product, Category, Movement, Supplier, MovementTypeEnum, MovementTypeLabels } from '@/types'
import InputError from '@/components/InputError.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    movement: Movement,
    products: Product[],
    categories: Category[],
    users: User[],
    suppliers: Supplier[],
    types: MovementTypeEnum,
}>();

const form = useForm({
    type: props.movement?.type,
    product_id: props.movement?.product_id || '',
    quantity: props.movement?.quantity || '',
    user_id: props.movement?.user_id || '',
    supplier_id: props.movement?.supplier_id || '',
    reference: props.movement?.reference || '',
    date: props.movement?.date,
    notes: props.movement?.notes || '',
});

const submit = () => {
    if (props.movement) {
        form.put(route('admin.movements.update', props.movement.id), {
            onSuccess: () => {
                form.reset();
            },
        });
    } else {
        form.post(route('admin.movements.store'), {
            onSuccess: () => {
                form.reset();
            },
        })
    }
};
</script>
<template>
    <AppLayout>

        <Head :title="movement ? 'Modifier un mouvement' : 'Créer un mouvement'" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4">
            <p class="alert success" v-if="$page.props.flash.message">
                {{ $page.props.flash.message }}
            </p>
            <Heading :title="movement ? 'Modifier un mouvement' : 'Créer un mouvement'" />

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Champ Type de mouvement -->
                    <div class="grid gap-2">
                        <Label for="type">Type de mouvement</Label>
                        <select id="type" v-model="form.type" class="p-2 border rounded" required>
                            <option value="" disabled>Sélectionnez un type</option>
                            <option v-for="[value, label] in Object.entries(MovementTypeLabels)" :key="value"
                                :value="value">
                                {{ label }}
                            </option>
                        </select>
                        <InputError :message="form.errors.type" />
                    </div>

                    <!-- Champ Produit -->
                    <div class="grid gap-2">
                        <Label for="product_id">Produit</Label>
                        <select id="product_id" v-model="form.product_id" class="p-2 border rounded" required>
                            <option value="" disabled>Sélectionnez un produit</option>
                            <option v-for="product in products" :key="product.id" :value="product.id">
                                {{ product.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.product_id" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">

                    <!-- Champ Quantité -->
                    <div class="grid gap-2">
                        <Label for="quantity">Quantité</Label>
                        <Input id="quantity" type="number" v-model="form.quantity" placeholder="Quantité" required />
                        <InputError :message="form.errors.quantity" />
                    </div>

                    <!-- Champ Utilisateur -->
                    <div class="grid gap-2">
                        <Label for="user_id">Utilisateur</Label>
                        <select id="user_id" v-model="form.user_id" class="p-2 border rounded" required>
                            <option value="" disabled>Sélectionnez un utilisateur</option>
                            <option v-for="user in users" :key="user.id" :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.user_id" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Champ Fournisseur -->
                    <div class="grid gap-2">
                        <Label for="supplier_id">Fournisseur</Label>
                        <select id="supplier_id" v-model="form.supplier_id" class="p-2 border rounded">
                            <option value="" disabled>Sélectionnez un fournisseur</option>
                            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                                {{ supplier.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.supplier_id" />
                    </div>

                    <!-- Champ Référence -->
                    <div class="grid gap-2">
                        <Label for="reference">Référence</Label>
                        <Input id="reference" type="text" v-model="form.reference" placeholder="Référence" />
                        <InputError :message="form.errors.reference" />
                    </div>
                </div>

                <!-- Champ Date -->
                <div class="grid gap-2">
                    <Label for="date">Date</Label>
                    <Input id="date" type="date" v-model="form.date" required />
                    <InputError :message="form.errors.date" />
                </div>

                <!-- Champ Notes -->
                <div class="grid gap-2">
                    <Label for="notes">Notes</Label>
                    <textarea id="notes" v-model="form.notes" class="p-2 border rounded" placeholder="Notes"></textarea>
                    <InputError :message="form.errors.notes" />
                </div>

                <!-- Bouton de soumission -->
                <Button type="submit" class="mt-4 w-full" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    {{ movement ? 'Mettre à jour' : 'Créer' }}
                </Button>
            </form>
        </div>
    </AppLayout>
</template>
