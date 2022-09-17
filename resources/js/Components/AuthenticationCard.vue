<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cyan-800">
        <img src="/img/background_login.png" class="absolute w-full top-0 left-0 h-full object-cover" alt="BackgroundLogin">
        <div class="w-full sm:max-w-4xl mt-6 px-12 pt-12 pb-32 bg-white/90 shadow-md sm:rounded-lg relative">
            <div class="flex flex-col sm:justify-center items-center">
                <slot name="logo" />
            </div>
            <slot />
        </div>
    </div>
</template>
