<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

<template>
	<Head>
		<link rel="preconnect" href="https://rsms.me/" />
		<link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
	</Head>
	<div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
		<header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
			<nav class="flex items-center justify-end gap-4">
				<Link
					v-if="$page.props.auth.user"
					:href="route('home')"
					class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
				>
					Accueil
				</Link>
				<template v-else>
					<Link
						:href="route('login')"
						class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
					>
						{{ t('auth.login') }}
					</Link>
					<Link
						:href="route('register')"
						class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
					>
						{{ t('auth.register') }}
					</Link>
				</template>
			</nav>
		</header>

		  <!-- Hero -->
		  <section class="text-center px-6 py-20 max-w-3xl mx-auto">
			<h1 class="text-4xl md:text-6xl font-extrabold text-neutral-100 leading-tight mb-6">
			  {{ t('home.title') }}
			</h1>
			<p class="text-lg text-neutral-400 mb-8">
			  {{ t('home.description') }}
			</p>
			<Link
				:href="route('register')"
				class="inline-block px-6 py-3 bg-orange-600 text-white rounded-md font-bold hover:bg-orange-500 transition"
			>
				{{ t('auth.register') }}
			</Link>
		  </section>

		  <!-- Features -->
		  <section id="features" class="max-w-5xl mx-auto px-6 py-16">
			<h2 class="text-2xl font-bold mb-10 text-orange-600 uppercase">Features</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center">

			  <div class="bg-neutral-900 p-6 rounded-lg">
				<svg class="mx-auto w-10 h-10 mb-4 icon" fill="none" viewBox="0 0 24 24"><path d="M2 12h4l2-4h6l2 4h4"></path></svg>
				<h3 class="font-semibold text-lg">Share Your Rides</h3>
			  </div>

			  <div class="bg-neutral-900 p-6 rounded-lg">
				<svg class="mx-auto w-10 h-10 mb-4 icon" fill="none" viewBox="0 0 24 24"><path d="M4 4h16v12H4z"></path><path d="M22 18H2"></path></svg>
				<h3 class="font-semibold text-lg">Chat with Bikers</h3>
			  </div>

			  <div class="bg-neutral-900 p-6 rounded-lg">
				<svg class="mx-auto w-10 h-10 mb-4 icon" fill="none" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4s-4 1.79-4 4 1.79 4 4 4zM4 20v-1c0-2.21 3.58-4 8-4s8 1.79 8 4v1H4z"></path></svg>
				<h3 class="font-semibold text-lg">Create Your Profile</h3>
			  </div>

			  <div class="bg-neutral-900 p-6 rounded-lg">
				<svg class="mx-auto w-10 h-10 mb-4 icon" fill="none" viewBox="0 0 24 24"><path d="M4 12l6 6L20 6"></path></svg>
				<h3 class="font-semibold text-lg">Join the Community</h3>
			  </div>

			</div>
		  </section>

		  <!-- Footer -->
		  <footer class="text-center text-sm text-neutral-500 py-6 border-t border-neutral-800">
			<p>© 2024 Burnout. All rights reserved.</p>
			<div class="space-x-4 mt-2">
			  <a href="#" class="hover:underline">Terms</a>
			  <a href="#" class="hover:underline">Privacy</a>
			</div>
		  </footer>
	</div>
</template>
