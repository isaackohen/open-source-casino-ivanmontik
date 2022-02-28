<template>
    <div>

                            <jet-action-section>
                                <template #title>
                                    Manage sub currencies
                                </template>

                                <template #description> 
                                    Delete sub currencies or hide them globally from all players. Hidden currencies will be disabled for deposits.
                                </template>

                                <!-- Currency List !-->
                                <template #content>
                                    <div class="space-y-6">
                                        <div class="flex items-center justify-between" v-for="currency in currencies" :key="currency.id">
                                            <div>
                                                {{ currency.name }}
                                                                                                <button v-if="currency.hidden === 0" class="cursor-pointer ml-1 text-xs text-gray-400 underline" @click="confirmUpdatingCurrency('hide', currency.id)">
                                                    Hide
                                                </button>
                                                <button v-if="currency.hidden === 1" class="cursor-pointer ml-1 text-xs text-gray-400 underline" @click="confirmUpdatingCurrency('unhide', currency.id)">
                                                    Unhide
                                                </button>
                                                <br>
                                                <span class="text-xs text-gray-400">Forwarding towards:<br>
                                                {{ currency.end_wallet }}</span>

                                            </div>

                                            <div class="flex items-center">
                                                <div class="text-sm text-gray-400" v-if="currency.updated_at">
                                                    {{ currency.usd_price }}$ USD<br>
                                                    <small>On {{ currency.updated_at }}</small>
                                                </div>

                                                <div class="text-sm ml-4 text-gray-400" v-if="currency.updated_at">
                                                    Player Balances:<br>
                                                    <small>{{ currency.sum }}{{ currency.code }}</small>
                                                </div>

                                                <button class="cursor-pointer ml-6 text-sm text-gray-400 underline">
                                                    View
                                                </button>

                                                <button class="cursor-pointer ml-6 text-sm text-red-500" @click="confirmDeletingCurrency(currency.id)">
                                                    Delete
                                                </button>
                                                 <jet-section-border />
                                            </div>
                                        </div>
                                    </div>
                                    <jet-button class="ml-2 mt-4" @click="updatePrices()" :class="{ 'opacity-25': updateCurrencyForm.processing }" :disabled="updateCurrencyForm.processing">
                                            Update Prices & Balances
                                    </jet-button>
                                </template>

                            </jet-action-section>


                <!-- Update Currency Modal -->
                <jet-confirmation-modal :show="updateModal" @close="updateModal = null">
                    <template #title>
                        Update Currency
                    </template>

                    <template #content>
                        Are you sure you want to update this currency?
                    </template>

                    <template #footer>
                        <jet-secondary-button @click="updateModal = null">
                            Cancel
                        </jet-secondary-button>

                        <jet-danger-button class="ml-3" @click="updatingCurrency" :class="{ 'opacity-25': updateCurrencyForm.processing }" :disabled="updateCurrencyForm.processing">
                            Update
                        </jet-danger-button>
                    </template>
                </jet-confirmation-modal>

                <!-- Delete Currency Modal -->
                <jet-confirmation-modal :show="currencyBeingDeleted" @close="currencyBeingDeleted = null">
                    <template #title>
                        Delete Currency
                    </template>

                    <template #content>
                        Are you sure you would like to delete this currency? It might cause issues if many users have been using this balance.
                    </template>

                    <template #footer>
                        <jet-secondary-button @click="currencyBeingDeleted = null">
                            Cancel
                        </jet-secondary-button>

                        <jet-danger-button class="ml-3" @click="destroyCurrency" :class="{ 'opacity-25': deleteCurrencyForm.processing }" :disabled="deleteCurrencyForm.processing">
                            Delete
                        </jet-danger-button>
                    </template>
                </jet-confirmation-modal>
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
            'currencies'
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


        data() {
            return {
                deleteCurrencyForm: this.$inertia.form(),
                updateCurrencyForm: this.$inertia.form(),
                updateModal: null,
                updateCurrency: null,
                currencyBeingDeleted: null,
            }
        },
        methods: {
            confirmDeletingCurrency(currency) {
                this.currencyBeingDeleted = currency
            },
            confirmUpdatingCurrency(method, currency) {
                this.updateModal = method,
                this.updateCurrency = currency
            },
            updatingCurrency() {
                this.updateCurrencyForm.put(route('admin.currencies.update', { currency: this.updateCurrency, method: this.updateModal }), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.updateModal = null, this.updateCurrency = null),
                })
            },
            updatePrices() {
                this.updateCurrencyForm.put(route('admin.currencies.update', { method: 'updatePrices' }), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.updateModal = null),
                })
            },            
            destroyCurrency() {
                this.deleteCurrencyForm.delete(route('admin.currencies.destroy', { id: this.currencyBeingDeleted }), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.currencyBeingDeleted = null),
                })
            },
        },
    })
</script>
