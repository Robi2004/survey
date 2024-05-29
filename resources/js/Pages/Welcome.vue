<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const logout = () => {
    router.post(route('logout'));
};

</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <h1 class="text-black text-center text-xl">Bienvenu sur le site de Sondix</h1>
                <header class="items-center py-10">
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-center">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('homepage')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Accueil
                        </Link>

                        <Link
                            v-if="$page.props.auth.user"
                            @click=logout()
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Déconnexion
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Connexion
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                S'enregistrer
                            </Link>
                        </template>
                    </nav>
                </header>

                <main v-if="$page.props.auth.user" class="mt-6">
                    <h1 class="text-center">Votre compte est en train d'être valider par un administareur.</h1>
                </main>
            </div>
        </div>
    </div>
</template>
