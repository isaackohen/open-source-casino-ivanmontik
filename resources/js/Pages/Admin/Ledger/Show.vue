<template>
    <app-layout title="Payment History">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ledger
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <withdraw-history :withdraw_history="$page.props.withdraw_history" />
                    <jet-section-border />
                </div>
                <div class="mt-4">
                    <payment-history :payment_history="$page.props.payment_history" />
                    <jet-section-border />
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import PaymentHistory from '@/Pages/Profile/Partials/PaymentHistory.vue'
    import WithdrawHistory from '@/Pages/Profile/Partials/WithdrawHistory.vue'

    export default defineComponent({
        props: ['payment_history', 'withdraw_history'],

        components: {
            AppLayout,
            WithdrawHistory,
            PaymentHistory,
        },
    })
</script>
