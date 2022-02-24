<template>
    <app-layout title="Withdraw Request">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Withdraw Request
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <withdraw-form :user="$page.props.user" :currentCurrency="$page.props.user.currentCurrency" />
                    <jet-section-border />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import WithdrawForm from '@/Pages/Profile/Partials/WithdrawForm.vue'

    export default defineComponent({
        props: ['balances'],

        components: {
            AppLayout,
            WithdrawForm,
        },
    })
</script>
