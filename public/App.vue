<template>
    <input type="text" v-model="name" class="bg-ctp-crust">
    <button class="text-ctp-pink underline">Demander un bonjour ?</button>
    <h1 v-show="!!hello">{{ hello }}</h1>
    <button class="btn btn-neutral">Neutral</button>
</template>

