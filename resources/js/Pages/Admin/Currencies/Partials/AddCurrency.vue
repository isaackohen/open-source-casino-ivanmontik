<template>
    <jet-form-section @submitted="addSubCurrency">
        <template #title>
            Add Sub Currency
        </template>

        <template #description>
            <p>Add new sub currency to be used for deposits & withdrawals. All sub-currencies are paired to <b>'native'</b> currency setup.
            <br>Native currencies are used by slotmachines. By default this is USD$ value.</p>
            <br><br>
            <p>Please note that once a currency has balances stored within greater as 10$, the currency can <b>not</b> be deleted for security reasons - in this case set currency to hidden.</p>
            <br>
            <p>Once currency is hidden only players with balance in such currency will be able to see and make new deposits in such.</p>
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="code" value="Currency Code - used in deposit method" />
                <jet-input id="code" type="text" class="mt-1 block w-full" v-model="form.code" ref="code" autocomplete="code" />
                <jet-input-error :message="form.errors.code" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" ref="name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="end_wallet" value="End Wallet" />
                <jet-input id="end_wallet" type="text" class="mt-1 block w-full" v-model="form.end_wallet" ref="end_wallet" autocomplete="end_wallet" />
                <jet-input-error :message="form.errors.end_wallet" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="payment_method" value="Deposit Method" />
            <select id="payment_method" v-model="form.payment_method" ref="payment_method" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="payment_method">
                <optgroup label="Deposit Method">
                <option value="cryptapi">
                    cryptapi
                </option>
            </optgroup>
            </select>

            </div>


        <div class="col-span-6 sm:col-span-4">
            <jet-label for="price_api" value="Exchange Rate API - used in updating USD$ value for external games" />
            <select id="price_api" v-model="form.price_api" ref="price_api" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="price_api">
                <optgroup label="Price API">
                <option value="coingecko">
                    coingecko
                </option>
            </optgroup>
            </select>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <jet-label for="price_api_id" value="Exchange Rate Identifier" />
            <jet-input id="price_api_id" type="text" class="mt-1 block w-full" v-model="form.price_api_id" ref="price_api_id" autocomplete="price_api_id" />
            <jet-input-error :message="form.errors.price_api_id" class="mt-2" />
        </div>

        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Created new currency.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create currency
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
                    code: '',
                    price_api: '',
                    payment_method: '',
                    hidden: 0,
                    end_wallet: '',
                    price_api: '',
                    price_api_id: '',
                    name: ''
                }),
            }
        },

        methods: {
            addSubCurrency() {
                this.form.put(route('admin.currencies.store'), {
                    errorBag: 'addCurrency',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        if (this.form.errors.code) {
                            this.form.reset('code', 'code')
                            this.$refs.password.focus()
                        }

                        if (this.form.errors.code) {
                            this.form.reset('code')
                            this.$refs.code.focus()
                        }
                    }
                })
            },
        },
    })
</script>
