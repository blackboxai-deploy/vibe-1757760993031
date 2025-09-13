<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - LoveConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pink': {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #fbcfe8 100%); }
        .glass-effect { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.8); }
        .online-indicator { 
            width: 12px; 
            height: 12px; 
            background-color: #10B981; 
            border: 2px solid white; 
            border-radius: 50%; 
            position: absolute; 
            bottom: 0; 
            right: 0; 
        }
        .typing-indicator {
            display: flex;
            align-items: center;
            padding: 8px 12px;
        }
        .typing-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #9CA3AF;
            margin: 0 1px;
            animation: typing 1.4s infinite ease-in-out;
        }
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        @keyframes typing {
            0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
        .message-bubble {
            max-width: 70%;
            word-wrap: break-word;
        }
        .message-time {
            font-size: 0.75rem;
            color: #9CA3AF;
            margin-top: 4px;
        }
        .ai-badge {
            background: linear-gradient(45deg, #6366F1, #8B5CF6);
            color: white;
            font-size: 0.625rem;
            padding: 2px 6px;
            border-radius: 8px;
            margin-left: 4px;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <?php include 'includes/header.php'; ?>
    
    <div class="container mx-auto px-6 py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-[calc(100vh-12rem)]">
            
            <!-- Left Sidebar - Conversations List -->
            <div class="lg:col-span-4">
                <div class="glass-effect rounded-3xl shadow-lg border border-pink-100 h-full flex flex-col">
                    <!-- Header -->
                    <div class="p-6 border-b border-pink-100">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Messages</h2>
                        <div class="relative">
                            <input type="text" placeholder="Search conversations..." 
                                   class="w-full pl-10 pr-4 py-3 bg-white/70 border border-pink-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all duration-200">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Conversations -->
                    <div class="flex-1 overflow-y-auto p-4">
                        <div class="space-y-2">
                            <!-- Active Conversation -->
                            <div class="flex items-center space-x-4 p-4 rounded-2xl bg-pink-100 border-2 border-pink-200 cursor-pointer transition-all duration-200" 
                                 onclick="selectChat('sophia')">
                                <div class="relative">
                                    <img src="https://placehold.co/50x50?text=AI+Assistant+Sophia+chat+support" 
                                         alt="Sophia AI" 
                                         class="w-12 h-12 rounded-full border-2 border-pink-300">
                                    <div class="online-indicator"></div>
                                    <span class="ai-badge">AI</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-800 truncate">Sophia AI Assistant</h4>
                                        <span class="text-xs text-gray-500">2m</span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">Great conversation starter! How about...</p>
                                    <div class="flex items-center mt-1">
                                        <span class="bg-pink-500 text-white text-xs px-2 py-1 rounded-full">2</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Other Conversations -->
                            <div class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-pink-50 cursor-pointer transition-all duration-200" 
                                 onclick="selectChat('sarah')">
                                <div class="relative">
                                    <img src="https://placehold.co/50x50?text=Sarah+dating+profile+beautiful+woman" 
                                         alt="Sarah" 
                                         class="w-12 h-12 rounded-full">
                                    <div class="online-indicator"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-800 truncate">Sarah Martinez</h4>
                                        <span class="text-xs text-gray-500">15m</span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">That coffee place sounds amazing! 😊</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-pink-50 cursor-pointer transition-all duration-200" 
                                 onclick="selectChat('emma')">
                                <div class="relative">
                                    <img src="https://placehold.co/50x50?text=Emma+dating+profile+attractive+woman" 
                                         alt="Emma" 
                                         class="w-12 h-12 rounded-full">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-800 truncate">Emma Johnson</h4>
                                        <span class="text-xs text-gray-500">1h</span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">Thanks for the hiking recommendation!</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-pink-50 cursor-pointer transition-all duration-200" 
                                 onclick="selectChat('alex')">
                                <div class="relative">
                                    <img src="https://placehold.co/50x50?text=AI+Bot+Alex+dating+assistant" 
                                         alt="Alex AI" 
                                         class="w-12 h-12 rounded-full border-2 border-blue-200">
                                    <div class="online-indicator"></div>
                                    <span class="ai-badge">AI</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-800 truncate">Alex Thompson</h4>
                                        <span class="text-xs text-gray-500">2h</span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">Would love to explore the city together!</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-pink-50 cursor-pointer transition-all duration-200" 
                                 onclick="selectChat('lisa')">
                                <div class="relative">
                                    <img src="https://placehold.co/50x50?text=Lisa+dating+profile+lovely+woman" 
                                         alt="Lisa" 
                                         class="w-12 h-12 rounded-full">
                                    <div class="w-3 h-3 bg-yellow-400 border-2 border-white rounded-full absolute bottom-0 right-0"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-800 truncate">Lisa Chen</h4>
                                        <span class="text-xs text-gray-500">3h</span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">Great music taste! 🎵</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="lg:col-span-8">
                <div class="glass-effect rounded-3xl shadow-lg border border-pink-100 h-full flex flex-col">
                    
                    <!-- Chat Header -->
                    <div id="chat-header" class="p-6 border-b border-pink-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <img id="chat-avatar" src="https://placehold.co/50x50?text=AI+Assistant+Sophia+chat+support" 
                                         alt="Chat Avatar" 
                                         class="w-12 h-12 rounded-full border-2 border-pink-200">
                                    <div class="online-indicator"></div>
                                </div>
                                <div>
                                    <h3 id="chat-name" class="font-bold text-gray-800 flex items-center">
                                        Sophia AI Assistant
                                        <span class="ai-badge ml-2">AI</span>
                                    </h3>
                                    <p id="chat-status" class="text-sm text-green-600">Active now</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <button class="p-3 rounded-full hover:bg-pink-100 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                    </svg>
                                </button>
                                <button class="p-3 rounded-full hover:bg-pink-100 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                    </svg>
                                </button>
                                <button class="p-3 rounded-full hover:bg-pink-100 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4">
                        <!-- Welcome Message -->
                        <div class="flex items-start space-x-3">
                            <img src="https://placehold.co/40x40?text=AI+Assistant+Sophia+chat+support" 
                                 alt="Sophia AI" 
                                 class="w-10 h-10 rounded-full border-2 border-pink-200 flex-shrink-0">
                            <div class="message-bubble">
                                <div class="bg-gray-100 rounded-2xl rounded-tl-md p-4">
                                    <p class="text-gray-800">Hi! I'm Sophia, your AI dating assistant! 👋 I'm here to help you have better conversations and give dating advice. What would you like to chat about?</p>
                                </div>
                                <div class="message-time">2:34 PM</div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 justify-end">
                            <div class="message-bubble">
                                <div class="bg-pink-500 text-white rounded-2xl rounded-tr-md p-4">
                                    <p>Hi Sophia! I'm nervous about my first date tomorrow. Any tips?</p>
                                </div>
                                <div class="message-time text-right">2:35 PM</div>
                            </div>
                            <img src="https://placehold.co/40x40?text=<?php echo substr($username, 0, 1); ?>" 
                                 alt="You" 
                                 class="w-10 h-10 rounded-full border-2 border-pink-200 flex-shrink-0">
                        </div>

                        <div class="flex items-start space-x-3">
                            <img src="https://placehold.co/40x40?text=AI+Assistant+Sophia+chat+support" 
                                 alt="Sophia AI" 
                                 class="w-10 h-10 rounded-full border-2 border-pink-200 flex-shrink-0">
                            <div class="message-bubble">
                                <div class="bg-gray-100 rounded-2xl rounded-tl-md p-4">
                                    <p class="text-gray-800">Absolutely! Here are my top first date tips: 1) Be yourself - authenticity is attractive 2) Ask open-ended questions to show genuine interest 3) Choose a comfortable location 4) Put your phone away and be present 5) Listen actively and find common interests. What kind of date are you planning? ✨</p>
                                </div>
                                <div class="message-time">2:36 PM</div>
                            </div>
                        </div>
                    </div>

                    <!-- Typing Indicator -->
                    <div id="typing-indicator" class="px-6 py-2 hidden">
                        <div class="flex items-start space-x-3">
                            <img src="https://placehold.co/40x40?text=AI+Assistant+Sophia+chat+support" 
                                 alt="Sophia AI" 
                                 class="w-8 h-8 rounded-full border-2 border-pink-200">
                            <div class="bg-gray-100 rounded-2xl rounded-tl-md p-3">
                                <div class="typing-indicator">
                                    <div class="typing-dot"></div>
                                    <div class="typing-dot"></div>
                                    <div class="typing-dot"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="p-6 border-t border-pink-100">
                        <div class="flex items-end space-x-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <textarea id="message-input" 
                                              placeholder="Type your message..." 
                                              class="w-full px-4 py-3 pr-12 bg-white/70 border border-pink-200 rounded-2xl resize-none focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all duration-200"
                                              rows="1"
                                              onkeypress="handleKeyPress(event)"></textarea>
                                    <button onclick="sendMessage()" 
                                            class="absolute right-3 bottom-3 p-2 bg-pink-500 hover:bg-pink-600 text-white rounded-full transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Additional Controls -->
                            <div class="flex items-center space-x-2">
                                <button class="p-3 text-gray-500 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                
                                <button class="p-3 text-gray-500 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Quick Suggestions -->
                        <div id="quick-suggestions" class="mt-4 flex flex-wrap gap-2">
                            <button onclick="sendQuickMessage('What makes a great first impression?')" 
                                    class="px-3 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 rounded-full text-sm transition-colors duration-200">
                                First impression tips
                            </button>
                            <button onclick="sendQuickMessage('How do I start a conversation?')" 
                                    class="px-3 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 rounded-full text-sm transition-colors duration-200">
                                Conversation starters
                            </button>
                            <button onclick="sendQuickMessage('What should I wear on a date?')" 
                                    class="px-3 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 rounded-full text-sm transition-colors duration-200">
                                Outfit advice
                            </button>
                            <button onclick="sendQuickMessage('Help me plan a romantic date')" 
                                    class="px-3 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 rounded-full text-sm transition-colors duration-200">
                                Date ideas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentChat = 'sophia';
        let isTyping = false;

        // Chat data
        const chats = {
            sophia: {
                name: 'Sophia AI Assistant',
                avatar: 'https://placehold.co/50x50?text=AI+Assistant+Sophia+chat+support',
                status: 'Active now',
                isAI: true,
                messages: []
            },
            sarah: {
                name: 'Sarah Martinez',
                avatar: 'https://placehold.co/50x50?text=Sarah+dating+profile+beautiful+woman',
                status: 'Active now',
                isAI: false,
                messages: []
            },
            emma: {
                name: 'Emma Johnson',
                avatar: 'https://placehold.co/50x50?text=Emma+dating+profile+attractive+woman',
                status: 'Last seen 1h ago',
                isAI: false,
                messages: []
            },
            alex: {
                name: 'Alex Thompson',
                avatar: 'https://placehold.co/50x50?text=AI+Bot+Alex+dating+assistant',
                status: 'Active now',
                isAI: true,
                messages: []
            },
            lisa: {
                name: 'Lisa Chen',
                avatar: 'https://placehold.co/50x50?text=Lisa+dating+profile+lovely+woman',
                status: 'Last seen 3h ago',
                isAI: false,
                messages: []
            }
        };

        // AI Responses for different personalities
        const aiResponses = {
            sophia: [
                "That's a great question! Based on my understanding of relationship psychology, I'd suggest...",
                "I love helping with dating advice! Here's what I think would work best...",
                "From what I've learned about successful relationships, the key is...",
                "That's totally normal to feel that way! Let me share some insights...",
                "You're on the right track! Here are some additional tips...",
            ],
            alex: [
                "I completely understand! I've been in similar situations...",
                "That sounds like an amazing opportunity! I'd love to hear more about...",
                "You know, I was just thinking about something similar earlier...",
                "That's so interesting! I have a completely different perspective on...",
                "I'm really enjoying our conversation! What do you think about...",
            ]
        };

        function selectChat(chatId) {
            currentChat = chatId;
            const chat = chats[chatId];
            
            // Update header
            document.getElementById('chat-name').innerHTML = chat.name + (chat.isAI ? '<span class="ai-badge ml-2">AI</span>' : '');
            document.getElementById('chat-avatar').src = chat.avatar;
            document.getElementById('chat-status').textContent = chat.status;
            document.getElementById('chat-status').className = chat.status.includes('Active') ? 'text-sm text-green-600' : 'text-sm text-gray-500';
            
            // Update active conversation in sidebar
            document.querySelectorAll('.lg\\:col-span-4 .space-y-2 > div').forEach(div => {
                div.classList.remove('bg-pink-100', 'border-2', 'border-pink-200');
                div.classList.add('hover:bg-pink-50');
            });
            
            // Clear messages area for demo (in real app, load chat history)
            const messagesContainer = document.getElementById('messages-container');
            messagesContainer.innerHTML = '';
            
            if (chat.isAI) {
                // Add welcome message for AI chats
                addMessage(chat.avatar, `Hi! I'm ${chat.name.split(' ')[0]}. How can I help you today? 😊`, false, true);
                
                // Show quick suggestions for AI chats
                document.getElementById('quick-suggestions').style.display = 'flex';
            } else {
                // Hide suggestions for human chats
                document.getElementById('quick-suggestions').style.display = 'none';
                
                // Add a sample message for human chats
                addMessage(chat.avatar, "Hey there! Thanks for matching with me 😊", false, false);
            }
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function sendMessage() {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            
            if (!message) return;
            
            // Add user message
            addMessage('https://placehold.co/40x40?text=<?php echo substr($username, 0, 1); ?>', message, true, false);
            input.value = '';
            autoResize(input);
            
            // Show typing indicator and send AI response
            if (chats[currentChat].isAI) {
                showTypingIndicator();
                setTimeout(() => {
                    hideTypingIndicator();
                    generateAIResponse(message);
                }, 1000 + Math.random() * 2000); // 1-3 seconds delay
            }
        }

        function sendQuickMessage(message) {
            document.getElementById('message-input').value = message;
            sendMessage();
        }

        function addMessage(avatar, text, isUser, isAI) {
            const messagesContainer = document.getElementById('messages-container');
            const messageDiv = document.createElement('div');
            const currentTime = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            messageDiv.className = `flex items-start space-x-3 ${isUser ? 'justify-end' : ''}`;
            messageDiv.innerHTML = `
                ${!isUser ? `<img src="${avatar}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-pink-200 flex-shrink-0">` : ''}
                <div class="message-bubble">
                    <div class="${isUser ? 'bg-pink-500 text-white' : 'bg-gray-100'} rounded-2xl ${isUser ? 'rounded-tr-md' : 'rounded-tl-md'} p-4">
                        <p class="${isUser ? 'text-white' : 'text-gray-800'}">${text}</p>
                    </div>
                    <div class="message-time ${isUser ? 'text-right' : ''}">${currentTime}</div>
                </div>
                ${isUser ? `<img src="${avatar}" alt="You" class="w-10 h-10 rounded-full border-2 border-pink-200 flex-shrink-0">` : ''}
            `;
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function showTypingIndicator() {
            if (isTyping) return;
            isTyping = true;
            document.getElementById('typing-indicator').classList.remove('hidden');
            const messagesContainer = document.getElementById('messages-container');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function hideTypingIndicator() {
            isTyping = false;
            document.getElementById('typing-indicator').classList.add('hidden');
        }

        function generateAIResponse(userMessage) {
            const chat = chats[currentChat];
            let response = '';
            
            // Simple keyword-based responses (in real app, use OpenAI API)
            const lowerMessage = userMessage.toLowerCase();
            
            if (lowerMessage.includes('nervous') || lowerMessage.includes('anxiety')) {
                response = "It's completely natural to feel nervous! Here are some tips to calm those pre-date jitters: Take deep breaths, remind yourself that they already liked you enough to say yes, and focus on having fun rather than impressing them. Remember, the right person will appreciate the real you! 💪✨";
            } else if (lowerMessage.includes('conversation') || lowerMessage.includes('talk')) {
                response = "Great conversation starters include asking about their passions, recent travels, or favorite local spots. Try open-ended questions like 'What's been the highlight of your week?' or 'What's something you're really excited about lately?' Avoid yes/no questions and really listen to their answers! 🗣️💫";
            } else if (lowerMessage.includes('date') && lowerMessage.includes('plan')) {
                response = "I love helping plan dates! For a first date, I'd suggest something interactive but not too intense - maybe a coffee walk, mini golf, or visiting a local market. The key is choosing something that allows for easy conversation. What are their interests? That can help narrow down the perfect activity! 🎯💕";
            } else if (lowerMessage.includes('outfit') || lowerMessage.includes('wear')) {
                response = "Outfit choice depends on your date location, but here's my golden rule: dress like the best version of yourself! Comfortable but put-together works best. If it's casual, try nice jeans with a flattering top. For dinner dates, a dress or button-down with chinos works great. Most importantly, wear something that makes YOU feel confident! 👗✨";
            } else if (lowerMessage.includes('text') || lowerMessage.includes('message')) {
                response = "Texting etiquette is so important! Keep it light and positive, mirror their energy and response time, and ask engaging questions. Avoid overwhelming them with too many messages if they haven't responded. Quality over quantity is key! What specific texting situation are you dealing with? 📱💬";
            } else {
                // Random supportive response
                const responses = aiResponses[currentChat] || aiResponses.sophia;
                const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                response = randomResponse + " What specific aspect would you like me to help you with? I'm here to support your dating journey! 🌟";
            }
            
            addMessage(chat.avatar, response, false, true);
        }

        // Auto-resize textarea
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
        }

        // Initialize chat
        document.addEventListener('DOMContentLoaded', function() {
            selectChat('sophia');
            
            // Auto-resize message input
            const messageInput = document.getElementById('message-input');
            messageInput.addEventListener('input', function() {
                autoResize(this);
            });
            
            // Simulate periodic online status updates
            setInterval(function() {
                const onlineIndicators = document.querySelectorAll('.online-indicator');
                onlineIndicators.forEach(indicator => {
                    if (Math.random() > 0.9) {
                        indicator.style.animation = 'pulse 2s infinite';
                    }
                });
            }, 10000);
        });
    </script>
</body>
</html>