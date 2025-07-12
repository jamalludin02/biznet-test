<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 font-sans">
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-4xl mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
            </div>
            <div>
              <h1 class="text-xl font-bold text-gray-900">AI Knowledge Chat</h1>
              <p class="text-sm text-gray-500">Powered by Gemma via Ollama</p>
            </div>
          </div>
          <div class="flex items-center space-x-2">
            <div class="flex space-x-1">
              <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
              <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.1s"></div>
              <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
            </div>
            <span class="text-sm text-gray-500">{{ connectionStatus }}</span>
          </div>
        </div>
      </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 py-6">
      <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div 
          ref="messagesContainer"
          class="h-96 overflow-y-auto p-6 space-y-4"
          @scroll="handleScroll"
        >
          <div v-if="messages.length === 0" class="text-center py-8">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Welcome to AI Knowledge Chat!</h3>
            <p class="text-gray-600 mb-4">I'm powered by Gemma and ready to help you with your questions.</p>
            <div class="flex flex-wrap justify-center gap-2">
              <button 
                v-for="suggestion in quickSuggestions" 
                :key="suggestion"
                @click="sendMessage(suggestion)"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full text-sm transition-colors duration-200"
              >
                {{ suggestion }}
              </button>
            </div>
          </div>

          <div 
            v-for="(message, index) in messages" 
            :key="index"
            class="flex items-end"
            :class="{ 'justify-end': message.type === 'user' }"
          >
            <div class="flex items-start space-x-3 max-w-lg">
              <div 
                :class="message.type === 'user' ? 'order-2' : 'order-1'"
                class="flex-shrink-0"
              >
                <div 
                  :class="message.type === 'user' 
                    ? 'w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center' 
                    : 'w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center'"
                >
                  <svg v-if="message.type === 'user'" class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <svg v-else class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                  </svg>
                </div>
              </div>

              <div 
                :class="message.type === 'user' ? 'order-1' : 'order-2'"
                class="flex-1"
              >
                <div 
                  class="p-3 rounded-lg"
                  :class="{
                    'bg-blue-500 text-white': message.type === 'user',
                    'bg-gray-100 text-gray-800': message.type === 'ai'
                  }"
                >
                  <p class="whitespace-pre-wrap text-sm">{{ message.content }}</p>
                  <div class="text-xs opacity-70 mt-2 text-right">
                    {{ formatTime(message.timestamp) }}
                    <span v-if="message.model" class="ml-2 font-semibold">{{ message.model }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-if="isTyping" class="flex items-end">
             <div class="flex items-start space-x-3 max-w-lg">
                <div class="flex-shrink-0 w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div class="p-3 rounded-lg bg-gray-100">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="border-t border-gray-200 p-4 bg-white">
          <form @submit.prevent="sendMessage" class="flex items-start space-x-3">
            <div class="flex-1">
              <textarea
                v-model="newMessage"
                @keydown.enter="handleEnterKey"
                placeholder="Type your message here... (Ctrl+Enter to send)"
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                rows="1"
                ref="messageInput"
                :disabled="isTyping"
              ></textarea>
            </div>
            <button
              type="submit"
              :disabled="!newMessage.trim() || isTyping"
              class="px-4 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 disabled:bg-blue-300 disabled:cursor-not-allowed transition-colors flex items-center space-x-2"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
              <span>Send</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, nextTick, onMounted } from 'vue';

export default {
  name: 'App',
  setup() {
    const messages = ref([]);
    const newMessage = ref('');
    const isTyping = ref(false);
    const messagesContainer = ref(null);
    const messageInput = ref(null);
    const connectionStatus = ref('Connecting...');
    const isUserNearBottom = ref(true);

    const quickSuggestions = [
      "Jam berapa sekarang waktu WIB",
      "How do I manage my business data?",
      "Tell me about your features",
      "Help me get started",
      "Halo selamat malam"
    ];

    const formatTime = (timestamp) => {
      return new Date(timestamp).toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
      });
    };

    const autoResizeTextarea = () => {
      nextTick(() => {
        const textarea = messageInput.value;
        if (textarea) {
          textarea.style.height = 'auto';
          textarea.style.height = `${textarea.scrollHeight}px`;
        }
      });
    };

    const handleEnterKey = (event) => {
      autoResizeTextarea();
      if (event.key === 'Enter' && event.ctrlKey) {
        event.preventDefault();
        sendMessage();
      }
    };

    const checkConnection = async () => {
      try {
        const response = await fetch('http://localhost:11434/api/tags');
        if (!response.ok) throw new Error('Failed to connect');
        const data = await response.json();
        connectionStatus.value = data.models && data.models.length > 0 ? 'Connected' : 'Disconnected';
        return data.models && data.models.length > 0;
      } catch (error) {
        connectionStatus.value = 'Disconnected';
        return false;
      }
    };

    const sendToOllama = async (userMessage) => {
      try {
        const response = await fetch('http://localhost:11434/api/chat', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
              "model": "gemma3:1b",
              "messages": [{
                  "role": "user",
                  "content": userMessage
              }],
              "stream": false
          })
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error communicating with Ollama:', error);
        return {
          message: {
            content: "I apologize, but I'm having trouble connecting to the AI service right now. Please check if the Ollama service is running and try again."
          }
        };
      }
    };

    // Scroll ke bawah HANYA jika user memang sudah di bawah sebelumnya
    const scrollToBottomIfNeeded = () => {
      if (isUserNearBottom.value && messagesContainer.value) {
        messagesContainer.value.scrollTo({
          top: messagesContainer.value.scrollHeight,
          behavior: 'smooth',
        });
      }
    };

    // Event scroll: update flag posisi user
    const handleScroll = () => {
      if (!messagesContainer.value) return;
      const { scrollTop, scrollHeight, clientHeight } = messagesContainer.value;
      isUserNearBottom.value = (scrollHeight - scrollTop - clientHeight) < 50;
    };

    const sendMessage = async (messageText = null) => {
      const content = typeof messageText === 'string' ? messageText : newMessage.value.trim();
      if (!content || isTyping.value) return;

      messages.value.push({
        type: 'user',
        content: content,
        timestamp: new Date()
      });

      // Reset input dan tingginya setiap kali pesan terkirim (dari suggestion maupun textarea)
      newMessage.value = '';
      autoResizeTextarea();

      isTyping.value = true;
      await nextTick();
      scrollToBottomIfNeeded();

      try {
        const aiResponse = await sendToOllama(content);
        messages.value.push({
          type: 'ai',
          content: aiResponse.message.content,
          timestamp: new Date(),
          model: 'gemma3:1b'
        });
      } catch (error) {
        messages.value.push({
          type: 'ai',
          content: "I apologize, but I encountered an error while processing your request. Please try again.",
          timestamp: new Date()
        });
      } finally {
        isTyping.value = false;
        await nextTick();
        scrollToBottomIfNeeded();
        messageInput.value?.focus();
      }
    };

    onMounted(async () => {
      messageInput.value?.focus();
      if(messageInput.value) {
          messageInput.value.addEventListener('input', autoResizeTextarea);
      }
      await checkConnection();
      setInterval(checkConnection, 30000);
    });

    return {
      messages,
      newMessage,
      isTyping,
      messagesContainer,
      messageInput,
      quickSuggestions,
      connectionStatus,
      formatTime,
      sendMessage,
      handleEnterKey,
      autoResizeTextarea,
      handleScroll
    };
  }
}
</script>
