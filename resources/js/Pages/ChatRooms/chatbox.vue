<template>
  <div>
    <div class="fixed bottom-2 right-2 bg-blue-900 rounded-xl" style="width: 64px; height: 64px;">
      <button @click="toggleChatbox" class="mx-auto flex justify-center items-center" style="width: 64px; height: 64px;">
        <div v-html="chatboxIcon"></div>
      </button>
    </div>
    <div :class="{ hidden: !isChatboxOpen }" class="fixed bottom-24 right-2 bg-gray-200 border-2 border-blue-400"
         style="min-width: 400px; max-width: 30%; height: 600px">
      <div class="p-6 flex flex-col justify-between h-full">
        <div class="pb-4 mb-4 border-b-2 border-b-gray-400">
          <h2 class="text-2xl text-center">Chat with Customer Support</h2>
        </div>
        <div class="overflow-y-scroll h-full" ref="messagesList">
          <div>
            <div class="font-bold">System</div>
            <p>Hello, how can we help you?</p>
          </div>
          <div v-for="(message, index) in messages" :key="index" :class="message.position">
            <div class="font-bold">{{ message.sender }}</div>
            <p>{{ message.text }}</p>
          </div>
        </div>
        <div class="pt-4 mt-4 border-t-2 border-t-gray-400">
          <textarea v-model="messageText" class="w-full"></textarea>
          <button @click="sendMessage" class="w-full bg-blue-300 py-2">Send Message</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'


const MESSAGE_ICON = `
  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="-3 -2 32 32" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail p-0 m-0">
    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
    <polyline points="22,6 12,13 2,6"></polyline>
  </svg>
`

const CLOSE_ICON = `
  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="-3 -2 32 32" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x p-0 m-0">
    <line x1="18" y1="6" x2="6" y2="18"></line>
    <line x1="6" y1="6" x2="18" y2="18"></line>
  </svg>
`

const isChatboxOpen = ref(false)
const chatboxIcon = ref(MESSAGE_ICON)
const messages = ref([{ position: 'text-left', sender: 'System', text: 'Hello, how can we help you?' }])
const messageText = ref('')
const messagesList = ref(null)
const identifier = `${authId}-${uniqueId}`

const toggleChatbox = () => {
  isChatboxOpen.value = !isChatboxOpen.value
  chatboxIcon.value = isChatboxOpen.value ? CLOSE_ICON : MESSAGE_ICON
}

const sendMessage = async () => {
  const message = messageText.value
  if (!message) return

  await fetch(sendMessageRoute, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ message, identifier })
  })

  messages.value.push({ position: 'text-right', sender: 'You', text: message })
  messageText.value = ''
  scrollToBottom()
}

const scrollToBottom = () => {
  messagesList.value.scrollTop = messagesList.value.scrollHeight
}

onMounted(() => {
  window.Echo.private(`adminRepliedToChatRoom.${identifier}`)
    .listen('AdminSentChatMessageEvent', (e) => {
      messages.value.push({ position: 'text-left', sender: 'Customer Support', text: e.message })
      scrollToBottom()
    })
})
</script>

<script>
const authId = '{{ auth()->id() }}'
const uniqueId = '{{ uniqid() }}'
const sendMessageRoute = route('send-message');
</script>

<style scoped>
.hidden {
  display: none;
}
</style>