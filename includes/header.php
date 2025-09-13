<?php
session_start();
?>
<!-- Header -->
<nav class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-pink-100">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="index.php" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-pink-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-pink-600 bg-clip-text text-transparent">
                        LoveConnect
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200">
                    Home
                </a>
                <a href="#features" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200">
                    Features
                </a>
                <a href="#testimonials" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200">
                    Success Stories
                </a>
                <a href="#about" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200">
                    About
                </a>
                <a href="#contact" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200">
                    Contact
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged in user menu -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-pink-600 transition-colors duration-200">
                            <img src="https://placehold.co/32x32?text=<?php echo substr($_SESSION['username'], 0, 1); ?>" 
                                 alt="Profile" 
                                 class="w-8 h-8 rounded-full">
                            <span class="font-medium"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 glass-effect rounded-2xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-pink-100">
                            <div class="py-2">
                                <a href="dashboard.php" class="block px-4 py-2 text-gray-700 hover:text-pink-600 hover:bg-pink-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </div>
                                </a>
                                <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:text-pink-600 hover:bg-pink-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>My Profile</span>
                                    </div>
                                </a>
                                <a href="chat.php" class="block px-4 py-2 text-gray-700 hover:text-pink-600 hover:bg-pink-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path>
                                        </svg>
                                        <span>Messages</span>
                                    </div>
                                </a>
                                <a href="settings.php" class="block px-4 py-2 text-gray-700 hover:text-pink-600 hover:bg-pink-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Settings</span>
                                    </div>
                                </a>
                                <hr class="my-2 border-pink-100">
                                <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Logout</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Not logged in -->
                    <a href="login.php" class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200">
                        Sign In
                    </a>
                    <a href="register.php" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Get Started Free
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-pink-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white/95 backdrop-blur-md border-t border-pink-100">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.php" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                    Home
                </a>
                <a href="#features" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                    Features
                </a>
                <a href="#testimonials" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                    Success Stories
                </a>
                <a href="#about" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                    About
                </a>
                <a href="#contact" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                    Contact
                </a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged in mobile menu -->
                    <hr class="my-3 border-pink-100">
                    <a href="dashboard.php" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                        Dashboard
                    </a>
                    <a href="profile.php" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                        My Profile
                    </a>
                    <a href="chat.php" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                        Messages
                    </a>
                    <a href="settings.php" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                        Settings
                    </a>
                    <a href="logout.php" class="block px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 font-medium transition-colors duration-200">
                        Logout
                    </a>
                <?php else: ?>
                    <!-- Not logged in mobile menu -->
                    <hr class="my-3 border-pink-100">
                    <a href="login.php" class="block px-3 py-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 font-medium transition-colors duration-200">
                        Sign In
                    </a>
                    <a href="register.php" class="block px-3 py-2 rounded-lg text-white bg-pink-500 hover:bg-pink-600 font-medium transition-colors duration-200">
                        Get Started Free
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
});
</script>