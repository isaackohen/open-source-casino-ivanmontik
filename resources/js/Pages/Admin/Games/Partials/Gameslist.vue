<template>
    <div>
    <jet-action-section>
            <template #title>
                Gameslist
            </template>

            <template #description> 
                You can delete games from list.
                <br><br>
                After you update games from API, you will need to re-delete unwanted games.
            </template>

            <template #content>
                <div class="space-y-4">
                    <div class="flex items-center justify-between" v-for="game in games">
                        <div>
                            {{ game.game_name }} 
                            <small class="ml-1 text-xs text-gray-400">
                                {{ game.game_slug }}
                            </small>
                        <br>
                        <span class="text-xs text-gray-500">by {{ game.game_provider }}</span>
                        </div>

                        <div class="flex items-center text-xs text-gray-400">
                                {{ game.type }}
                            <button class="cursor-pointer underline ml-6 text-sm text-red-500 hover:text-red-700" @click="confirmDeleteGame(game.game_slug)">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                        <div class="mt-8 overflow-hidden sm:rounded-lg text-center font-semibold text-gray-500">
                        <button @click="loadGames()" class="h-10 px-6 text-indigo-700 text-sm transition-colors duration-[100ms] ease border border-indigo-500 rounded-full hover:bg-indigo-500 hover:text-indigo-100">
                            Load more
                        </button>
                    </div>
                </div>
            </template>
    </jet-action-section>

        <!-- Delete Game -->
        <jet-confirmation-modal :show="deleteGameModal" @close="deleteGameModal = null">
            <template #title>
                <strong>Delete Game</strong>
            </template>

            <template #content>
                <p>You are sure to delete {{ deleteGameModal }} from games list?</p>
            </template>

            <template #footer>
                <jet-secondary-button @click="deleteGameModal = null">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-3" @click="deleteGame" :class="{ 'opacity-25': deleteGameForm.processing }" :disabled="deleteGameForm.processing">
                    Delete Game
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
            'games'
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
                deleteGameForm: this.$inertia.form(),
                deleteGameModal: null,
                currentPage: 1,
                games: [],
            }
        },
        mounted() {
            this.loadGames();
        },
        methods: {
        confirmDeleteGame(slug) {
            this.deleteGameModal = slug
        },
        deleteGame() {
            this.deleteGameForm.put(route('admin.games.delete', { game: this.deleteGameModal }), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => (this.deleteGameModal = null, this.games = [], this.currentPage = 1, this.loadGames()),
            })
        },
        loadGames() {
            const current = this.currentPage;
            fetch('/api/gamelistAdmin?page=' + current)
            .then(res => {return res.json()})
            .then(data => {
                
            const list = data.data;
            list.forEach((game) => {
                this.games.push(game);
            });

          this.currentPage = current + 1;

            });
        },
        },
    })
</script>
