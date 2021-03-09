<template>
    <section class="chat-box">
        <div class="chat-box-list-container" ref="chatbox">
            <ul class="chat-box-list">
                <li
                        class="message"
                        v-for="(message, idx) in messages"
                        :key="idx"
                        :class="message.author"
                >
                    <p>
                        <span>{{message.login}}: {{ message.text }}</span>
                    </p>
                </li>
            </ul>
        </div>
        <div class="chat-inputs">
            <input
                    type="text"
                    v-model="message"
                    @keyup.enter="sendMessage"
                    :disabled='isDisabled'
            />
            <button @click="sendMessage" :disabled='isDisabled'>Send</button>
        </div>
    </section>
</template>

<script>
    import axios from "axios";

    export default {
        name: 'Chat',
        data: () => ({
            message: '',
            messages: [],
            test: null,
            loading: true,
            token: 'qPccOOacmiufeG3Gss3iM_mqehTaw1L5',
            disable: true,
        }),
        mounted() {
            axios.get(
                'http://localhost:8080/api/message',
                {headers: {Authorization: `Bearer ${this.token}`}}
            ).then(res => {
                res.data.forEach(el =>
                    this.messages.push({
                        text: el.message,
                        login: el.login,
                        author: 'server'
                    })
                )

                setTimeout(() => {
                    this.test = res.data;
                    this.loading = false
                }, 1000)


                this.$nextTick(() => {
                    this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
                })
            }).catch(error => console.log(error));
        },
        methods: {
            sendMessage() {
                const message = this.message;
                this.disable = false;
                this.$axios.post(`http://localhost:8080/api/message`,
                    {message: message},
                    {headers: {Authorization: `Bearer ${this.token}`}}
                ).then(res => {
                    this.messages.push({
                        text: message,
                        login: 'you',
                        author: 'client'
                    });
                    this.disable = true;
                    this.$nextTick(() => {
                        this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
                    })
                }).catch(error => console.log(error));
            }
        },
        computed: {
            isDisabled: function(){
                return !this.disable;
            }
        }
    }
</script>

<style scoped lang="scss">
    .chat-box,
    .chat-box-list {
        display: flex;
        flex-direction: column;
        list-style-type: none;
    }

    .chat-box-list-container {
        overflow: scroll;
        margin-bottom: 1px;
        height: 45vh;
    }

    .chat-box-list {
        padding-left: 10px;
        padding-right: 10px;

        span {
            padding: 1px;
            color: white;
            border-radius: 1px;
        }

        .server {
            span {
                background: #99cc00;
            }

            p {
                display: inline-block; word-wrap: break-word;
                float: right;
            }
        }

        .client {
            span {
                background: #0070C8;
            }

            p {
                float: left;
            }
        }
    }

    .chat-box {
        margin: 10px;
        border: 1px solid #999;
        width: 50vw;
        height: 50vh;
        border-radius: 4px;
        margin-left: auto;
        margin-right: auto;
        align-items: space-between;
        justify-content: space-between;
    }

    .chat-inputs {
        display: flex;

        input {
            line-height: 3;
            width: 100%;
            border: 1px solid #999;
            border-left: none;
            border-bottom: none;
            border-right: none;
            border-bottom-left-radius: 4px;
            padding-left: 15px;
        }

        button {
            width: 145px;
            color: white;
            background: #0070C8;
            border-color: #999;
            border-bottom: none;
            border-right: none;
            border-bottom-right-radius: 3px;
        }
    }
</style>