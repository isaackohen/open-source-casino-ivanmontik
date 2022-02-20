<template>
    <div>
        <jet-action-section>
            <template #title>
                Test API Games
            </template>

            <template #description> 
                Run individual tests to see if your connection is correct.
                <br><br>For test we will use your current logged in user. We will add balance to the user for this test.
                <br><br>You can set your API Key in settings.json located within /storage/ folder.
                <br><br><small>Loaded apikey: {{ apikey }}</small>
            </template>

            <!-- Currency List !-->
            <template #content>
                <div>
                    <div class="flex items-center justify-between">
                        <div>
                            Create Sesssion Test
                            <br><small class="text-gray-400">Create game session on random slotmachine in your games list.</small>
                        </div>

                        <div class="flex items-center">
                            <button @click="confirmTest('createSession')" class="cursor-pointer ml-6 text-sm text-gray-400 underline">
                                Run Test
                            </button>
                        </div>
                    </div>
                             <jet-section-border />
                    <div class="flex items-center justify-between">
                        <div>
                            Balance Test
                            <br><small class="text-gray-400">Test if you are returning balance to API correctly for games to function properly.</small>
                        </div>

                        <div class="flex items-center">
                            <button @click="confirmTest('balance')" class="cursor-pointer ml-6 text-sm text-gray-400 underline">
                                Run Test
                            </button>
                        </div>
                    </div>


                </div>
            </template>
        </jet-action-section>

        <!-- Update Games -->
        <jet-confirmation-modal :show="testModal" @close="testModal = null">
            <template #title>
                <strong>Test API</strong>
            </template>

            <template #content>
                <p>Confirm that we are to run test: {{ testModal }}.</p>
                <jet-section-border />
            </template>

            <template #footer>
                <jet-secondary-button @click="testModal = null">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-3" @click="runTest" :class="{ 'opacity-25': testModalForm.processing }" :disabled="testModalForm.processing">
                    Run Test
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
                testModalForm: this.$inertia.form(),
                testModal: null,
            }
        },

        methods: {
            confirmTest(method) {
                this.testModal = method
            },
            runTest() {
                this.testModalForm.put(route('admin.games.test', { method: this.testModal }), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.testModal = null),
                })
            },
        },
    })
</script>
