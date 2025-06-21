<?php 
    session_start();
    if (empty($_SESSION['is_login'])) {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sidebar: {
                            DEFAULT: '#0f172a',
                            foreground: '#e2e8f0'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-color: #f5f7fa;
            --container-bg: white;
            --text-color: #2c3e50;
            --text-secondary: #6c757d;
            --border-color: #e9ecef;
            --hover-bg: #f8f9fa;
            --even-row-bg: #fafbfc;
            --shadow: rgba(0, 0, 0, 0.1);
            --sidebar-bg: #0f172a;
            --sidebar-text: #e2e8f0;
        }

        [data-theme="dark"] {
            --bg-color: #1a1a1a;
            --container-bg: #2d2d2d;
            --text-color: #e0e0e0;
            --text-secondary: #b0b0b0;
            --border-color: #404040;
            --hover-bg: #3a3a3a;
            --even-row-bg: #333333;
            --shadow: rgba(0, 0, 0, 0.3);
        }

        [data-theme="dark"] .bg-gray-50 {
            background-color: var(--bg-color) !important;
        }

        [data-theme="dark"] .bg-white {
            background-color: var(--container-bg) !important;
        }

        [data-theme="dark"] .text-gray-800,
        [data-theme="dark"] .text-gray-900 {
            color: var(--text-color) !important;
        }

        [data-theme="dark"] .text-gray-600,
        [data-theme="dark"] .text-gray-700 {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] .border-gray-200,
        [data-theme="dark"] .border-gray-300 {
            border-color: var(--border-color) !important;
        }

        [data-theme="dark"] .shadow,
        [data-theme="dark"] .shadow-sm,
        [data-theme="dark"] .shadow-lg {
            box-shadow: 0 4px 6px var(--shadow) !important;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .theme-toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .product-table-container {
            background: var(--container-bg);
            border-radius: 12px;
            box-shadow: 0 4px 6px var(--shadow);
            overflow: hidden;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            font-size: 0.9rem;
        }

        .product-table thead {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .product-table th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
        }

        .product-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            color: var(--text-color);
        }

        .product-table tbody tr:hover {
            background-color: var(--hover-bg);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px var(--shadow);
        }

        .product-table tbody tr:nth-child(even) {
            background-color: var(--even-row-bg);
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.1);
            border-color: #4facfe;
        }

        .product-id {
            font-weight: 600;
            color: var(--text-color);
            font-family: 'Courier New', monospace;
        }

        .product-name {
            font-weight: 500;
            color: var(--text-color);
        }

        .qty {
            text-align: center;
            font-weight: 600;
            color: #28a745;
        }

        .price {
            font-weight: 600;
            color: #dc3545;
            text-align: right;
        }

        

        .user-id {
            font-family: 'Courier New', monospace;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .timestamp {
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-active {
            background-color: #28a745;
        }

        .status-low-stock {
            background-color: #ffc107;
        }

        .status-out-of-stock {
            background-color: #dc3545;
        }

        [data-theme="dark"] .qty {
            color: #4ade80;
        }

        [data-theme="dark"] .price {
            color: #f87171;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-table {
                font-size: 0.8rem;
            }
            
            .product-table th,
            .product-table td {
                padding: 10px 8px;
            }
            
            .product-image {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {
            .product-table th:nth-child(6),
            .product-table td:nth-child(6),
            .product-table th:nth-child(7),
            .product-table td:nth-child(7),
            .product-table th:nth-child(8),
            .product-table td:nth-child(8) {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50" data-theme="light">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-sidebar text-sidebar-foreground shadow-lg">
            <div class="p-6 flex items-center justify-between">
                <h1 class="text-xl font-bold text-white">Dashboard</h1>
                <button onclick="toggleTheme()" class="theme-toggle-btn">
                    <svg id="theme-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
            </div>
            
            <nav class="mt-6">
                <div class="px-6 py-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</p>
                </div>
                <a href="#" onclick="showPage('home')" class="nav-link flex items-center px-6 py-3 text-white bg-slate-700 border-r-2 border-blue-500" data-page="home">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Home
                </a>
                <a href="#" onclick="showPage('analytics')" class="nav-link flex items-center px-6 py-3 text-gray-300 hover:text-white hover:bg-slate-700 transition-colors" data-page="analytics">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Analytics
                </a>
                <a href="#" onclick="showPage('users')" class="nav-link flex items-center px-6 py-3 text-gray-300 hover:text-white hover:bg-slate-700 transition-colors" data-page="users">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Users
                </a>
                <a href="#" onclick="showPage('products')" class="nav-link flex items-center px-6 py-3 text-gray-300 hover:text-white hover:bg-slate-700 transition-colors" data-page="products">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Products
                </a>
                
                <a style="margin-top: 300px;" href="#" onclick="showPage('settings')" class="nav-link flex items-center px-6 py-3 text-gray-300 hover:text-white hover:bg-slate-700 transition-colors" data-page="settings">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button class="text-gray-500 hover:text-gray-700 md:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h2 id="page-title" class="text-xl font-semibold text-gray-800 ml-2">Dashboard Overview</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative hidden md:block">
                            <input type="text" placeholder="Search..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                            </svg>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                        </button>
                        
                        <!-- User Menu -->
                        <div class="flex items-center space-x-3">
                            <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="User">
                            <span class="text-sm font-medium text-gray-700 hidden md:block">John Doe</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                <!-- Home Page Content -->
                <div id="home-page" class="page-content">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                                    <p class="text-2xl font-semibold text-gray-900">2,543</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-green-500 text-sm font-medium">+12%</span>
                                <span class="text-gray-600 text-sm ml-2">from last month</span>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Revenue</p>
                                    <p class="text-2xl font-semibold text-gray-900">$45,231</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-green-500 text-sm font-medium">+8%</span>
                                <span class="text-gray-600 text-sm ml-2">from last month</span>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-2 bg-yellow-100 rounded-lg">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Orders</p>
                                    <p class="text-2xl font-semibold text-gray-900">1,423</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-red-500 text-sm font-medium">-3%</span>
                                <span class="text-gray-600 text-sm ml-2">from last month</span>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Conversion</p>
                                    <p class="text-2xl font-semibold text-gray-900">3.24%</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-green-500 text-sm font-medium">+0.5%</span>
                                <span class="text-gray-600 text-sm ml-2">from last month</span>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Tables -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Chart Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Overview</h3>
                            <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                                <p class="text-gray-500">Chart Placeholder</p>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">New user registered</p>
                                        <p class="text-xs text-gray-500">2 minutes ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Order #1234 completed</p>
                                        <p class="text-xs text-gray-500">5 minutes ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Payment pending</p>
                                        <p class="text-xs text-gray-500">10 minutes ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics Page Content -->
                <div id="analytics-page" class="page-content hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Traffic Analytics</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Page Views</span>
                                    <span class="text-sm font-semibold">45,231</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Unique Visitors</span>
                                    <span class="text-sm font-semibold">12,543</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Bounce Rate</span>
                                    <span class="text-sm font-semibold">23.4%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-red-600 h-2 rounded-full" style="width: 23%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Pages</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b">
                                    <span class="text-sm text-gray-900">/dashboard</span>
                                    <span class="text-sm text-gray-600">2,543 views</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b">
                                    <span class="text-sm text-gray-900">/products</span>
                                    <span class="text-sm text-gray-600">1,892 views</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b">
                                    <span class="text-sm text-gray-900">/users</span>
                                    <span class="text-sm text-gray-600">1,234 views</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm text-gray-900">/settings</span>
                                    <span class="text-sm text-gray-600">892 views</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Page Content -->
                <div id="users-page" class="page-content hidden">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-900">User Management</h3>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add User</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Jane Cooper</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">jane.cooper@example.com</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Admin</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Cody Fisher</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">cody.fisher@example.com</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">User</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Products Page Content -->
                <div id="products-page" class="page-content hidden">
                    <div class="product-table-container">
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2" >Product Management</h1>
                                <p class="text-gray-600">Comprehensive product inventory and tracking system</p>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Product</button>
                                <table class="product-table mt-5">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>User ID</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            include 'connection.php';
                                            global $con;
                                            $selectProduct="SELECT *, `profile` FROM `tbproducts` INNER JOIN `tbusers` ON `user_id`=`userID`";
                                            $res=$con->query($selectProduct);
                                            while($row=$res->fetch_assoc()){
                                                echo '
                                                     <tr>
                                            <td>
                                                <img width="60" src="./uploads/'. $row['image']. '" />
                                            </td>
                                            <td class="product-id">'.$row['product_id'].'</td>
                                            <td class="product-name">
                                                <span class="status-indicator status-active"></span>
                                                '.$row['product_name'].'
                                            </td>
                                            <td class="qty">'.$row['qty'].'</td>
                                            <td class="price">'.$row['price'].'</td>
                                            <td class="user-id"><img width="60" src="./uploads/'. $row['profile']. '" /></td>
                                            <td class="timestamp">'.$row['create_at'].'</td>
                                            <td class="timestamp">'.$row['update_at'].'</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                        </td>
                                        </tr>
                                                ';
                                            }
                                        ?>
                                       
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <form action="function.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="" class="form-label">Product Name</label>
                                <input type="text" name="name" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Product Qty</label>
                                <input type="text" name="qty" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Product Price</label>
                                <input type="text" name="price" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Product Image</label>
                                <input type="file" name="image" id="" class="form-control">
                            </div>
                            <div class="form-group d-flex justify-content-end gap-2 mt-3">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="btnSave">Save </button>
                            </div>
                            
                       </form>
                    </div>
                   
                    </div>
                </div>
                </div>

                <!-- Settings Page Content -->
                <div id="settings-page" class="page-content hidden">
                    <div class="max-w-4xl">
                        <div class="bg-white rounded-lg shadow">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Account Settings</h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                        <input type="text" value="John" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                        <input type="text" value="Doe" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" value="john.doe@example.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Notifications</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">Email notifications</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">SMS notifications</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">Push notifications</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Dark mode functionality
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const currentTheme = body.getAttribute('data-theme');
            
            if (currentTheme === 'dark') {
                body.setAttribute('data-theme', 'light');
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>';
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            
            body.setAttribute('data-theme', savedTheme);
            
            if (savedTheme === 'dark') {
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>';
            } else {
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>';
            }
            
            showPage('home');
        });

        // Page navigation functionality
        function showPage(pageId) {
            // Hide all pages
            const pages = document.querySelectorAll('.page-content');
            pages.forEach(page => {
                page.classList.add('hidden');
            });
            
            // Show selected page
            const selectedPage = document.getElementById(pageId + '-page');
            if (selectedPage) {
                selectedPage.classList.remove('hidden');
            }
            
            // Update navigation active state
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.classList.remove('bg-slate-700', 'border-r-2', 'border-blue-500', 'text-white');
                link.classList.add('text-gray-300');
            });
            
            // Set active navigation item
            const activeLink = document.querySelector(`[data-page="${pageId}"]`);
            if (activeLink) {
                activeLink.classList.add('bg-slate-700', 'border-r-2', 'border-blue-500', 'text-white');
                activeLink.classList.remove('text-gray-300');
            }
            
            // Update page title
            const titles = {
                'home': 'Dashboard Overview',
                'analytics': 'Analytics',
                'users': 'User Management',
                'products': 'Products',
                'settings': 'Settings'
            };
            
            const pageTitle = document.getElementById('page-title');
            if (pageTitle && titles[pageId]) {
                pageTitle.textContent = titles[pageId];
            }
        }
    </script>
</body>
</html>