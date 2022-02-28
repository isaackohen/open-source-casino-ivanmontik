<template>
    <app-layout title="Login">
        <template #header>
            <h4 class="font-semibold text-xl text-gray-800 leading-tight">
                Login
            </h4>
        </template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>
        <div class="text-center pt-4 pb-8 border-b border-gray-200">
            <jet-button @click="loginWeb3">
                Login with MetaMask
            </jet-button>
        </div>
        <div class="py-6 text-sm text-gray-500 text-center">
            or login with your credentials…
        </div>
        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <jet-checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </Link>
                <Link :href="route('register')" class="underline ml-4 text-sm text-gray-600 hover:text-gray-900">
                    Register
                </Link>
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
        </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Link, useForm } from '@inertiajs/inertia-vue3';
    import Web3 from 'web3/dist/web3.min.js'

    export default defineComponent({
        components: {
            AppLayout,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            async loginWeb3() {
                if (! window.ethereum) {
                    alert('MetaMask not detected. Please try again from a MetaMask enabled browser.')
                }

                const web3 = new Web3(window.ethereum);

                const message = [
                    "I have read and accept the terms and conditions.",
                    "Please sign me in!"
                ].join("\n")

                const address = (await web3.eth.requestAccounts())[0]
                const signature = await web3.eth.personal.sign(message, address)

                return useForm({ message, address, signature }).post('/login-web3')
            },
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    })
</script>
