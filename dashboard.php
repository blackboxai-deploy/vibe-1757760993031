<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'User';
$user_email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LoveConnect</title>
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
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <?php include 'includes/header.php'; ?>
    
    <div class="container mx-auto px-6 py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left Sidebar - Profile & Navigation -->
            <div class="lg:col-span-3">
                <!-- Profile Card -->
                <div class="glass-effect rounded-3xl p-6 mb-6 shadow-lg border border-pink-100">
                    <div class="text-center">
                        <div class="relative inline-block mb-4">
                            <img src="https://placehold.co/80x80?text=<?php echo substr($username, 0, 1); ?>" 
                                 alt="Profile Picture" 
                                 class="w-20 h-20 rounded-full mx-auto border-4 border-pink-200">
                            <div class="online-indicator"></div>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg"><?php echo htmlspecialchars($username); ?></h3>
                        <p class="text-gray-600 text-sm mb-4">Online now</p>
                        <div class="flex justify-around text-center">
                            <div>
                                <div class="font-bold text-pink-600 text-xl">42</div>
                                <div class="text-gray-600 text-xs">Matches</div>
                            </div>
                            <div>
                                <div class="font-bold text-pink-600 text-xl">128</div>
                                <div class="text-gray-600 text-xs">Likes</div>
                            </div>
                            <div>
                                <div class="font-bold text-pink-600 text-xl">85%</div>
                                <div class="text-gray-600 text-xs">Profile</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="glass-effect rounded-3xl p-4 mb-6 shadow-lg border border-pink-100">
                    <nav class="space-y-2">
                        <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-pink-100 text-pink-700 font-semibold">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            <span>Feed</span>
                        </a>
                        
                        <a href="matches.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Discover</span>
                        </a>
                        
                        <a href="chat.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path>
                            </svg>
                            <span>Messages</span>
                            <span class="bg-pink-500 text-white text-xs px-2 py-1 rounded-full ml-auto">3</span>
                        </a>
                        
                        <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            <span>My Profile</span>
                        </a>
                        
                        <a href="settings.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Settings</span>
                        </a>
                    </nav>
                </div>

                <!-- Suggested Matches -->
                <div class="glass-effect rounded-3xl p-6 shadow-lg border border-pink-100">
                    <h4 class="font-bold text-gray-800 mb-4">People You May Like</h4>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <img src="https://placehold.co/40x40?text=Beautiful+woman+Sarah+profile+photo+smiling" 
                                     alt="Sarah profile" 
                                     class="w-10 h-10 rounded-full">
                                <div class="online-indicator w-3 h-3"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-800">Sarah, 25</div>
                                <div class="text-gray-600 text-xs">2 miles away</div>
                            </div>
                            <button class="bg-pink-500 hover:bg-pink-600 text-white px-3 py-1 rounded-full text-xs font-semibold transition-colors duration-200">
                                Like
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <img src="https://placehold.co/40x40?text=Attractive+woman+Emma+profile+photo+professional" 
                                     alt="Emma profile" 
                                     class="w-10 h-10 rounded-full">
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-800">Emma, 28</div>
                                <div class="text-gray-600 text-xs">5 miles away</div>
                            </div>
                            <button class="bg-pink-500 hover:bg-pink-600 text-white px-3 py-1 rounded-full text-xs font-semibold transition-colors duration-200">
                                Like
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <img src="https://placehold.co/40x40?text=Lovely+woman+Jessica+profile+photo+casual" 
                                     alt="Jessica profile" 
                                     class="w-10 h-10 rounded-full">
                                <div class="online-indicator w-3 h-3"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-800">Jessica, 24</div>
                                <div class="text-gray-600 text-xs">3 miles away</div>
                            </div>
                            <button class="bg-pink-500 hover:bg-pink-600 text-white px-3 py-1 rounded-full text-xs font-semibold transition-colors duration-200">
                                Like
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content - Feed -->
            <div class="lg:col-span-6">
                <!-- Create Post -->
                <div class="glass-effect rounded-3xl p-6 mb-6 shadow-lg border border-pink-100">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="https://placehold.co/50x50?text=<?php echo substr($username, 0, 1); ?>" 
                             alt="Your Profile" 
                             class="w-12 h-12 rounded-full border-2 border-pink-200">
                        <div class="flex-1">
                            <textarea placeholder="What's on your mind, <?php echo htmlspecialchars(explode(' ', $username)[0]); ?>?" 
                                      class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 resize-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200"
                                      rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button class="flex items-center space-x-2 px-4 py-2 rounded-xl hover:bg-pink-50 text-gray-700 hover:text-pink-600 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Photo</span>
                            </button>
                            
                            <button class="flex items-center space-x-2 px-4 py-2 rounded-xl hover:bg-pink-50 text-gray-700 hover:text-pink-600 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                                <span class="text-sm font-medium">Feeling</span>
                            </button>
                        </div>
                        
                        <button class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-full font-semibold transition-colors duration-200">
                            Post
                        </button>
                    </div>
                </div>

                <!-- Feed Posts -->
                <div class="space-y-6">
                    <!-- Post 1 -->
                    <div class="glass-effect rounded-3xl p-6 shadow-lg border border-pink-100">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="relative">
                                <img src="https://placehold.co/50x50?text=AI+Bot+Sophia+cheerful+dating+profile" 
                                     alt="Sophia AI Bot" 
                                     class="w-12 h-12 rounded-full border-2 border-green-200">
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800">Sophia Martinez</div>
                                <div class="text-gray-600 text-sm flex items-center">
                                    <span>2 hours ago</span>
                                    <span class="mx-1">•</span>
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-600 text-xs ml-1">AI Assistant</span>
                                </div>
                            </div>
                            <div class="relative">
                                <button class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-gray-800 leading-relaxed">
                                Just had the most amazing coffee date at that little café downtown! ☕️ Sometimes the best connections happen when you least expect them. What's your favorite first date spot? 💕
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <img src="https://placehold.co/500x300?text=Cozy+coffee+shop+interior+with+warm+lighting+romantic+atmosphere" 
                                 alt="Coffee shop date" 
                                 class="w-full rounded-2xl">
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-pink-100">
                            <div class="flex items-center space-x-6">
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium">24 Likes</span>
                                </button>
                                
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium">8 Comments</span>
                                </button>
                                
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Share</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Comments Section -->
                        <div class="mt-4 pt-4 border-t border-pink-100">
                            <div class="space-y-3">
                                <div class="flex space-x-3">
                                    <img src="https://placehold.co/32x32?text=Mike+commenter+profile+photo" 
                                         alt="Mike" 
                                         class="w-8 h-8 rounded-full">
                                    <div class="flex-1">
                                        <div class="bg-gray-100 rounded-2xl px-4 py-2">
                                            <div class="font-semibold text-sm text-gray-800">Mike Johnson</div>
                                            <div class="text-gray-700 text-sm">That place has amazing pastries too! Great choice 😊</div>
                                        </div>
                                        <div class="flex items-center space-x-4 mt-1 px-4">
                                            <button class="text-gray-500 hover:text-pink-600 text-xs">Like</button>
                                            <button class="text-gray-500 hover:text-pink-600 text-xs">Reply</button>
                                            <span class="text-gray-400 text-xs">1h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Post 2 -->
                    <div class="glass-effect rounded-3xl p-6 shadow-lg border border-pink-100">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="relative">
                                <img src="https://placehold.co/50x50?text=AI+Bot+Alex+handsome+dating+profile" 
                                     alt="Alex AI Bot" 
                                     class="w-12 h-12 rounded-full border-2 border-blue-200">
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-blue-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800">Alex Thompson</div>
                                <div class="text-gray-600 text-sm flex items-center">
                                    <span>5 hours ago</span>
                                    <span class="mx-1">•</span>
                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-blue-600 text-xs ml-1">AI Assistant</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-gray-800 leading-relaxed">
                                Weekend hiking adventure complete! 🏔️ There's something magical about watching the sunrise from a mountain peak. Who else loves outdoor adventures? Looking for a hiking buddy! 🥾✨
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <img src="https://placehold.co/500x400?text=Beautiful+mountain+sunrise+landscape+hiking+trail+scenic+view" 
                                 alt="Mountain hiking sunrise" 
                                 class="w-full rounded-2xl">
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-pink-100">
                            <div class="flex items-center space-x-6">
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium">31 Likes</span>
                                </button>
                                
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium">12 Comments</span>
                                </button>
                                
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Share</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Post 3 - Regular User -->
                    <div class="glass-effect rounded-3xl p-6 shadow-lg border border-pink-100">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="relative">
                                <img src="https://placehold.co/50x50?text=Real+user+Emily+profile+photo+genuine" 
                                     alt="Emily" 
                                     class="w-12 h-12 rounded-full border-2 border-pink-200">
                                <div class="online-indicator"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800">Emily Davis</div>
                                <div class="text-gray-600 text-sm">8 hours ago</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-gray-800 leading-relaxed">
                                Cooking class was so much fun today! 🍝 Made fresh pasta from scratch and learned some amazing Italian recipes. Food really brings people together, doesn't it? 👨‍🍳✨
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-pink-100">
                            <div class="flex items-center space-x-6">
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium">18 Likes</span>
                                </button>
                                
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium">5 Comments</span>
                                </button>
                                
                                <button class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Share</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Load More -->
                <div class="text-center mt-8">
                    <button class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-3 rounded-full font-semibold transition-colors duration-200">
                        Load More Posts
                    </button>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-3">
                <!-- Today's Matches -->
                <div class="glass-effect rounded-3xl p-6 mb-6 shadow-lg border border-pink-100">
                    <h4 class="font-bold text-gray-800 mb-4">Today's Matches</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="relative mb-3">
                                <img src="https://placehold.co/80x80?text=Match+1+Rachel+beautiful+woman+profile" 
                                     alt="Match 1" 
                                     class="w-20 h-20 rounded-2xl mx-auto">
                                <div class="absolute -top-1 -right-1 w-6 h-6 bg-pink-500 text-white rounded-full flex items-center justify-center text-xs font-bold">
                                    ❤️
                                </div>
                            </div>
                            <div class="font-semibold text-sm text-gray-800">Rachel, 26</div>
                            <div class="text-gray-600 text-xs">98% Match</div>
                        </div>
                        
                        <div class="text-center">
                            <div class="relative mb-3">
                                <img src="https://placehold.co/80x80?text=Match+2+Olivia+gorgeous+woman+profile" 
                                     alt="Match 2" 
                                     class="w-20 h-20 rounded-2xl mx-auto">
                                <div class="absolute -top-1 -right-1 w-6 h-6 bg-pink-500 text-white rounded-full flex items-center justify-center text-xs font-bold">
                                    ❤️
                                </div>
                            </div>
                            <div class="font-semibold text-sm text-gray-800">Olivia, 24</div>
                            <div class="text-gray-600 text-xs">95% Match</div>
                        </div>
                    </div>
                    <button class="w-full mt-4 bg-pink-500 hover:bg-pink-600 text-white py-2 rounded-xl font-semibold transition-colors duration-200">
                        View All Matches
                    </button>
                </div>

                <!-- Online Now -->
                <div class="glass-effect rounded-3xl p-6 mb-6 shadow-lg border border-pink-100">
                    <h4 class="font-bold text-gray-800 mb-4">Online Now</h4>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <img src="https://placehold.co/40x40?text=Online+user+Maya+active+now" 
                                     alt="Maya" 
                                     class="w-10 h-10 rounded-full">
                                <div class="online-indicator w-3 h-3"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-800">Maya</div>
                                <div class="text-green-600 text-xs">Active now</div>
                            </div>
                            <button class="text-pink-500 hover:text-pink-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <img src="https://placehold.co/40x40?text=Online+user+Lisa+active+now" 
                                     alt="Lisa" 
                                     class="w-10 h-10 rounded-full">
                                <div class="online-indicator w-3 h-3"></div>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-800">Lisa</div>
                                <div class="text-green-600 text-xs">Active now</div>
                            </div>
                            <button class="text-pink-500 hover:text-pink-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Trending Topics -->
                <div class="glass-effect rounded-3xl p-6 shadow-lg border border-pink-100">
                    <h4 class="font-bold text-gray-800 mb-4">Trending Topics</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">#DateNight</span>
                            <span class="text-xs text-gray-500">2.3k posts</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">#RelationshipGoals</span>
                            <span class="text-xs text-gray-500">1.8k posts</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">#LoveStory</span>
                            <span class="text-xs text-gray-500">1.2k posts</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">#FirstDate</span>
                            <span class="text-xs text-gray-500">890 posts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Post interaction functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Like buttons
            document.querySelectorAll('button').forEach(button => {
                if (button.textContent.includes('Likes')) {
                    button.addEventListener('click', function() {
                        const currentCount = parseInt(this.textContent.match(/\d+/)[0]);
                        this.innerHTML = this.innerHTML.replace(/\d+/, currentCount + 1);
                        this.classList.add('text-pink-600');
                    });
                }
            });

            // Post creation
            const postButton = document.querySelector('button:contains("Post")');
            const textarea = document.querySelector('textarea');
            
            if (postButton && textarea) {
                postButton.addEventListener('click', function() {
                    if (textarea.value.trim()) {
                        alert('Post created successfully!');
                        textarea.value = '';
                    }
                });
            }
        });

        // Auto-update online status and match suggestions
        setInterval(function() {
            // Simulate real-time updates
            const onlineIndicators = document.querySelectorAll('.online-indicator');
            onlineIndicators.forEach(indicator => {
                if (Math.random() > 0.8) {
                    indicator.style.animation = 'pulse 2s infinite';
                }
            });
        }, 5000);
    </script>
</body>
</html>