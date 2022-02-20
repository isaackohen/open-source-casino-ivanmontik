<template>
    <div>
        <jet-action-section>
            <template #title>
                Load Games
            </template>

            <template #description> 
                Update your games list externally using your API Key.
            </template>

            <!-- Currency List !-->
            <template #content>
                <div>
                    <div class="flex items-center justify-between">
                        <div>
                            Games <small class="text-gray-400">{{ gamescount }} loaded</small>
                        </div>

                        <div class="flex items-center">
                            <button @click="confirmUpdateGames(apikey)" class="cursor-pointer ml-6 text-sm text-gray-400 underline">
                                Update
                            </button>
                        </div>
                    </div>
                             <jet-section-border />
                    <div class="flex items-center justify-between">
                        <div>
                            Providers <small class="text-gray-400">{{ providerscount }} loaded</small>
                        </div>

                        <div class="flex items-center">
                            <button @click="confirmUpdateGames(apikey)" class="cursor-pointer ml-6 text-sm text-gray-400 underline">
                                Update
                            </button>
                        </div>
                    </div>


                </div>
            </template>
        </jet-action-section>

        <!-- Update Games -->
        <jet-confirmation-modal :show="updateModal" @close="updateModal = null">
            <template #title>
                <strong>Update Games</strong>
            </template>

            <template #content>
                <p>Are you sure you want to update games from API?</p>
                <jet-section-border />

                <p>Be aware the games list is <span class="underline">truncated</span> while we run games list update. This can cause errors if you have players playing at same time. We advise you to turn on maintenance mode. </p>
            </template>

            <template #footer>
                <jet-secondary-button @click="updateModal = null">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-3" @click="updateGames" :class="{ 'opacity-25': updateGamesForm.processing }" :disabled="updateGamesForm.processing">
                    Update
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
            'gamescount', 'providerscount', 'apikey'
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
                updateGamesForm: this.$inertia.form(),
                updateModal: null,
            }
        },

        methods: {
            confirmUpdateGames(apikey) {
                this.updateModal = apikey
            },
            updateGames() {
                this.updateGamesForm.put(route('admin.games.update', { apikey: this.updateModal }), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.updateModal = null),
                })
            },
        },
    })
</script>
