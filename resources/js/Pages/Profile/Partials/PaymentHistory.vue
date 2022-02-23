<template>
    <div>
    <jet-action-section>
            <template #title>
                Deposit History
            </template>

            <template #description> 
                Review your deposit history.
            </template>

            <template #content>
                <div class="space-y-4">
                    <div v-if="Object.keys(payment_history).length === 0" class="flex items-center justify-center">
                        <div class="text-sm text-gray-500">
                                No deposits made yet. 
                        </div>
                    </div>
                    <div class="flex items-center justify-between" v-for="payment in payment_history">
                        <div>
                            {{ payment.currency_code }} 
                            <small class="ml-1 text-xs text-gray-400">
                                ±{{ payment.usd_value }}$ at time of deposit
                            </small>
                        <br>
                        <span class="text-xs text-gray-500">Tx. id {{ payment.transaction_id }} </span>
                        </div>

                        <div class="flex items-center text-md text-green-500">
                                +{{ payment.amount }} {{ payment.currency_code }}
                        </div>
                    </div>
                </div>
            </template>
    </jet-action-section> 

</div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetActionSection from '@/Jetstream/ActionSection.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
    import JetDangerButton from '@/Jetstream/DangerButton.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'

    export default defineComponent({

        props: [
            'payment_history'
        ],

        components: {
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetDialogModal,
            JetFormSection,
            JetInput,
            JetCheckbox,
            JetInputError, 
            JetLabel,
            JetSecondaryButton,
            JetSectionBorder,
        },
    })
</script>
