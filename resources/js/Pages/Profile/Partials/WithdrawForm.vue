<template>
    <jet-form-section @submitted="withdrawRequest">
        <template #title>
            Withdraw Request
        </template>

        <template #description>
            Create a withdraw request.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="withdraw_currency" value="Withdraw Currency" />
                <jet-input id="withdraw_currency" :placeholder="$page.props.user.currentCurrency" :value="$page.props.user.currentCurrency" disabled type="text" class="mt-1 block w-full" v-model="form.withdraw_currency" ref="withdraw_currency" autocomplete="current-withdraw_currency" />
                <jet-input-error :message="form.errors.withdraw_currency" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="withdraw_address" value="Withdraw Address" />
                <jet-input id="withdraw_address" type="number" placeholder="Enter your wallet address" class="mt-1 block w-full" v-model="form.withdraw_address" ref="withdraw_address" autocomplete="current-withdraw_address" />
                <jet-input-error :message="form.errors.withdraw_address" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="withdraw_amount" value="Amount to withdraw" />
                <jet-input id="withdraw_amount" type="number" :placeholder="$page.props.user.currentBalance" class="mt-1 block w-full" v-model="form.withdraw_amount" ref="withdraw_amount" autocomplete="current-withdraw_amount" />
                <jet-input-error :message="form.errors.withdraw_amount" class="mt-2" />
            </div>


            
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Submitted..
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Request Withdraw
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'

    export default defineComponent({
        props: ['currentCurrency', 'user'],

        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput, 
            JetInputError,
            JetLabel,
        },

        data() {
            return {
                form: this.$inertia.form({
                    withdraw_currency: this.user.currentCurrency,
                    withdraw_address: '',
                    withdraw_amount: '',
                }),
            }
        },

        methods: {
            withdrawRequest() {
                this.form.put(route('withdrawRequest.submit'), {
                    errorBag: 'withdrawRequest',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        if (this.form.errors.withdraw_amount) {
                            this.form.reset('withdraw_amount')
                            this.$refs.withdraw_amount.focus()
                        }

                        if (this.form.errors.withdraw_currency) {
                            this.form.reset('withdraw_currency')
                            this.$refs.withdraw_currency.focus()
                        }
                    }
                })
            },
        },
    })
</script>
