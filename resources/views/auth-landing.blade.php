<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Cosmik - Study Group Finder</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <div class="w-full md:w-1/2 bg-teal-900 text-white flex flex-col justify-between p-8 md:p-16 lg:p-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
        
        <div class="flex items-center space-x-3 relative z-10">
            <div class="w-10 h-10 bg-white text-teal-900 rounded-xl flex items-center justify-center text-xl font-extrabold shadow-md">
                C
            </div>
            <span class="text-xl font-bold tracking-wider uppercase">Cosmik</span>
        </div>

        <div class="my-auto max-w-lg relative z-10 py-12 md:py-0">
            <span class="bg-teal-800 text-teal-200 text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wider">
                Student Academic Study Group Finder
            </span>
            <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight mt-4">
                Find Your Ideal Study Peers.
            </h1>
            <p class="mt-4 text-gray-200 text-base md:text-lg leading-relaxed">
                Student Academic Study Group Finder is a platform that helps students connect with classmates who share the same academic interests and study goals. Connect with classmates, join study groups, share resources, and achieve your academic goals together. Learning is easier when you study with the right people.
            </p>

            <div class="mt-8 space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="mt-1 bg-teal-800 p-1 rounded-lg">
                        <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-sm text-white">Search Your Study Groups</h4>
                        <p class="text-xs text-teal-200 mt-0.5">Filter active study clusters smoothly by subject codes, specialized titles, or imminent exam dates.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="mt-1 bg-teal-800 p-1 rounded-lg">
                        <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-sm text-white">Request & Join Groups</h4>
                        <p class="text-xs text-teal-200 mt-0.5">Group leaders hold authorization to manage roster limits, maintaining optimal sizes for productive interaction.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="mt-1 bg-teal-800 p-1 rounded-lg">
                        <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-sm text-white">Share Study Resources</h4>
                        <p class="text-xs text-teal-200 mt-0.5">Securely distribute relevant lecture notes, visual media, and shared materials directly within your dashboard.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-xs text-teal-300/80 relative z-10 pt-4 border-t border-teal-800/50 flex justify-between items-center">
            <span>&copy; 2026 Cosmik Hub. Built with Laravel MVC.</span>
            <a href="/privacy" class="text-teal-300/80 hover:text-teal-300 transition duration-150">Privacy Policy</a>
        </div>
    </div>


    <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-16 lg:p-24 bg-white">
        <div class="w-full max-w-sm">
            <div class="md:hidden flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 bg-teal-600 text-white rounded-xl flex items-center justify-center text-xl font-extrabold">
                    C
                </div>
                <span class="text-xl font-bold text-gray-900 tracking-wider uppercase">Cosmik</span>
            </div>

            <div class="text-left mb-8">
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Student Access Portal</h2>
                <p class="text-sm text-gray-500 mt-2">Log in via authentication or register an account to locate study circles.</p>
            </div>

            <div class="space-y-4">
                <a href="{{ route('login') }}" class="flex items-center justify-between w-full py-3.5 px-5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition duration-150 ease-in-out border-2 border-teal-700 shadow-md group">
                    <span>Sign In to Account</span>
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                
                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink mx-4 text-gray-400 text-xs font-semibold uppercase tracking-wider">or</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <a href="{{ route('register') }}" class="flex items-center justify-between w-full py-3.5 px-5 bg-white hover:bg-gray-50 text-gray-800 font-bold rounded-xl transition duration-150 ease-in-out border-2 border-slate-700 shadow-sm">
                    <span>Register New Account</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </a>
            </div>

            <div class="mt-12 pt-6 border-t border-gray-100">
                <p class="text-xs text-gray-400 leading-relaxed text-center md:text-left">
                    Authentication is strictly mandated to preserve a protected, verified student-only academic environment. 
                </p>
            </div>
        </div>
    </div>

</body>
</html>