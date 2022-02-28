<template>
    <app-layout title="Currencies">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Currencies
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <manage-currency :currencies="currencies" class="mt-4 sm:mt-0" />
                                        <jet-section-border />

                    <add-currency :available_crypto="available_crypto" class="mt-10 sm:mt-0" />
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
    import AddCurrency from '@/Pages/Admin/Currencies/Partials/AddCurrency.vue'
    import ManageCurrency from '@/Pages/Admin/Currencies/Partials/ManageCurrency.vue'

    export default defineComponent({
        props: ['currencies', 'available_crypto'],

        components: {
            AppLayout,
            ManageCurrency,
            JetSectionBorder,
            AddCurrency,
        },
    })
</script>
