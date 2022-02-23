<template>
    <div class="mt-6 px-2 py-8 sm:p-6 flex flex-col sm:justify-center items-center pt-0 sm:pt-0 bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-lg mt-4 px-7 py-5 bg-white shadow-sm overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
 