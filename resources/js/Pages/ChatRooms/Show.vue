<template>
  <AppLayout>
    <template #header>
      <h2 class="lg:px-40 font-semibold text-xl text-gray-800  leading-tight">
        Chat with {{ chatRoom.user.name }}
      </h2> 
    </template>

    <div class="py-20">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-80">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 relative" style="min-height: 400px;"> 
            <div id="chat-messages" class="overflow-y-auto absolute top-0 left-0 right-0 bottom-16">
              <div
                v-for="(message, index) in messages" 
                :key="index" 
                :class="{ 'text-right': auth.user.id === message.user.id }"
              >
                <div class="p-2 mb-2 rounded-lg" :class="{
                  'bg-blue-100': auth.user.id === message.user.id,
                  'bg-gray-200': auth.user.id !== message.user.id,
                }">
                  <span class="font-bold">{{ message.user.name }}:</span>
                  <p>{{ message.message }}</p>
                </div>
              </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 p-4">
              <textarea 
                class="w-full pt-2 rounded-lg  border border-gray-300 p-2" 
                v-model="newMessage"
                @keydown.enter.prevent="sendMessage"
              ></textarea>
              <button 
                @click="sendMessage"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2"
              >
                Send
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted, toRefs, nextTick } from 'vue'
import { router } from '@inertiajs/vue3'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'



const props = defineProps({
  chatRoom: Object,
  auth: Object,
});

// Access the chatRoom directly from props and use toRefs to unwrap its properties.
const { chatRoom, auth } = toRefs(props);
const newMessage = ref('');
const messages = ref(chatRoom.value.chatMessages); // Use chatMessages ref

const sendMessage = async () => {
    if (!newMessage.value.trim()) return; // Prevent empty messages

    try {
        await router.post(
            `/chat-rooms/${chatRoom.value.id}/messages`,
            { content: newMessage.value },
            { preserveScroll: true }
        ); // preserveScroll to avoid jumping to the top

        // Update messages after successful send (or you can receive the updated message from the response)
        messages.value.push({ user: auth.value.user, message: newMessage.value });
        newMessage.value = '';

        // Use nextTick to ensure the DOM is updated before scrolling
        await nextTick();
        scrollToBottom();
    } catch (error) {
        // Handle potential errors (e.g., display an error message to the user)
        console.error('Error sending message:', error);
    }
};

const scrollToBottom = () => {
    const chatMessagesElement = document.getElementById('chat-messages');
    if (chatMessagesElement) {
        chatMessagesElement.scrollTop = chatMessagesElement.scrollHeight;
    }
};

onMounted(() => {
    window.Echo.private(`adminRepliedToChatRoom.${chatRoom.value.id}`) // Correct channel name
        .listen('AdminSentChatMessageEvent', (e) => {
            messages.value.push({ user: e.chatMessage.user, message: e.chatMessage.message });
            scrollToBottom();
        });

    scrollToBottom(); // Scroll to bottom initially
});
</script>

<style scoped>
.hidden {
  display: none;
}
</style>