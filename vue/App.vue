<template>
    <div id="app">
        <Chat />
    </div>
</template>

<script>
    import Chat from './components/Chat.vue'
    export default {
        name: 'app',
        components: {
            Chat
        }
    }
</script>

<style>
    body{
        padding: 0;
        margin: 10px;
    }
    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin: 0;
        padding: 0;
    }
</style>
