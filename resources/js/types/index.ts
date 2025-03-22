import type { LucideIcon } from 'lucide-vue-next';
import type { PageProps } from '@inertiajs/core';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Product {
    id: number;
    name: string;
    description: string;
    sku: string;
    price: string | number;
    quantity: number;
    alert_level: number;
    category_id: number;
}

export interface Category {
    id: number;
    name: string;
    description?: string;
}

export enum MovementTypeEnum {
    IN = 'Entrée',
    OUT = 'Sortie',
}

// Interface pour le mouvement
export interface Movement {
    id: number;
    type: MovementTypeEnum;
    product_id: number;
    quantity: number;
    user_id: number;
    supplier_id: number | null;
    reference: string | null;
    date: Date;
    notes: string | null;
    created_at: Date;
    updated_at: Date;
    product?: Product;
    user?: User;
    supplier?: Supplier;
}

export interface Supplier {
    id: number;
    name: string;
    email: string | null;
    phone: string | null;
    address: string | null;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date | null;
}

export type BreadcrumbItemType = BreadcrumbItem;
