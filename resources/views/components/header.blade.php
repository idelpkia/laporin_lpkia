<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto" id="globalSearchForm">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Cari laporan, user, investigasi..."
                aria-label="Search" data-width="300" id="globalSearchInput" autocomplete="off">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result" id="searchResults">
                <!-- Search Histories -->
                <div class="search-header" id="historiesHeader" style="display: none;">
                    Riwayat Pencarian
                    <div class="float-right">
                        <a href="#" id="clearHistories"><small>Hapus Semua</small></a>
                    </div>
                </div>
                <div id="searchHistories"></div>

                <!-- Quick Access -->
                <div class="search-header">
                    Akses Cepat
                </div>
                <div id="quickAccess">
                    <div class="text-center py-2">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>

                <!-- Search Results will be populated here -->
                <div id="searchResultsContent"></div>
            </div>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">
        <!-- Dynamic Notifications -->
        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"
                id="notificationBell">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger notification-badge" id="notificationCount"
                    style="display: none;">0</span>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right" id="notificationDropdown">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="#" id="markAllAsRead">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons" id="notificationList">
                    <!-- Notifications will be loaded here via AJAX -->
                    <div class="text-center py-3" id="loadingNotifications">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('notifications.index') }}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if (Auth::user()->photo)
                    <img alt="image" src="{{ asset('storage/' . Auth::user()->photo) }}" class="rounded-circle mr-1">
                @else
                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="features-profile.html" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

@push('scripts')
    <script>
        $(document).ready(function() {
            var searchTimeout;
            var currentSearchQuery = '';

            // Load initial data
            loadNotifications();
            loadQuickAccess();

            // Reload notifications every 30 seconds
            setInterval(loadNotifications, 30000);

            // Global Search functionality
            $('#globalSearchInput').on('input', function() {
                var query = $(this).val().trim();

                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    showInitialContent();
                    return;
                }

                if (query === currentSearchQuery) {
                    return;
                }

                currentSearchQuery = query;

                // Show loading
                $('#searchResultsContent').html(
                    '<div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Mencari...</div>'
                );

                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 300);
            });

            // Handle search form submit
            $('#globalSearchForm').on('submit', function(e) {
                e.preventDefault();
                var query = $('#globalSearchInput').val().trim();
                if (query.length >= 2) {
                    performSearch(query);
                }
            });

            // Show/hide search results
            $('#globalSearchInput').on('focus', function() {
                $('.search-result').show();
                loadSearchHistories();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-element').length) {
                    $('.search-result').hide();
                }
            });

            // Handle history item clicks
            $(document).on('click', '.history-item', function(e) {
                e.preventDefault();
                var query = $(this).data('query');
                $('#globalSearchInput').val(query);
                performSearch(query);
            });

            // Handle history item removal
            $(document).on('click', '.remove-history', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var query = $(this).data('query');
                removeSearchHistory(query);
            });

            // Clear all histories
            $('#clearHistories').on('click', function(e) {
                e.preventDefault();
                clearSearchHistories();
            });

            // Handle notification bell click
            $('#notificationBell').on('click', function() {
                loadNotifications();
            });

            // Handle mark all as read
            $('#markAllAsRead').on('click', function(e) {
                e.preventDefault();
                markAllAsRead();
            });

            // Handle individual notification click
            $(document).on('click', '.notification-item', function(e) {
                e.preventDefault();
                var notificationId = $(this).data('id');
                var url = $(this).data('url');

                // Mark as read
                markAsRead(notificationId);

                // Redirect to URL if exists
                if (url && url !== '#') {
                    window.location.href = url;
                }
            });

            function performSearch(query) {
                $.ajax({
                    url: '{{ route('search.global') }}',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    success: function(response) {
                        displaySearchResults(response.results, query);
                        updateSearchHistories(response.histories);
                    },
                    error: function() {
                        $('#searchResultsContent').html(
                            '<div class="text-center py-3 text-danger">Terjadi kesalahan saat mencari</div>'
                        );
                    }
                });
            }

            function displaySearchResults(results, query) {
                var html = '';
                var hasResults = false;

                // Reports
                if (results.reports && results.reports.length > 0) {
                    html += '<div class="search-header">Laporan</div>';
                    results.reports.forEach(function(item) {
                        hasResults = true;
                        html += `
                    <a href="${item.url}" class="search-item">
                        <div class="search-icon bg-${item.color} mr-3 text-white">
                            <i class="${item.icon}"></i>
                        </div>
                        <div class="search-item-content">
                            <div class="search-item-title">${item.title}</div>
                            <div class="search-item-desc">${item.description}</div>
                            <div class="search-item-meta">
                                <span class="badge badge-${item.color}">${item.status}</span>
                                <small class="text-muted ml-2">${item.meta}</small>
                            </div>
                        </div>
                    </a>
                `;
                    });
                }

                // Users
                if (results.users && results.users.length > 0) {
                    html += '<div class="search-header">Pengguna</div>';
                    results.users.forEach(function(item) {
                        hasResults = true;
                        html += `
                    <a href="${item.url}" class="search-item">
                        <img class="mr-3 rounded-circle" width="30" src="${item.avatar}" alt="user">
                        <div class="search-item-content">
                            <div class="search-item-title">${item.title}</div>
                            <div class="search-item-desc">${item.description}</div>
                            <div class="search-item-meta">
                                <span class="badge badge-${item.color}">${item.meta}</span>
                            </div>
                        </div>
                    </a>
                `;
                    });
                }

                // Investigations
                if (results.investigations && results.investigations.length > 0) {
                    html += '<div class="search-header">Investigasi</div>';
                    results.investigations.forEach(function(item) {
                        hasResults = true;
                        html += `
                    <a href="${item.url}" class="search-item">
                        <div class="search-icon bg-${item.color} mr-3 text-white">
                            <i class="${item.icon}"></i>
                        </div>
                        <div class="search-item-content">
                            <div class="search-item-title">${item.title}</div>
                            <div class="search-item-desc">${item.description}</div>
                            <div class="search-item-meta">
                                <span class="badge badge-${item.color}">${item.status}</span>
                                <small class="text-muted ml-2">${item.meta}</small>
                            </div>
                        </div>
                    </a>
                `;
                    });
                }

                // Appeals
                if (results.appeals && results.appeals.length > 0) {
                    html += '<div class="search-header">Banding</div>';
                    results.appeals.forEach(function(item) {
                        hasResults = true;
                        html += `
                    <a href="${item.url}" class="search-item">
                        <div class="search-icon bg-${item.color} mr-3 text-white">
                            <i class="${item.icon}"></i>
                        </div>
                        <div class="search-item-content">
                            <div class="search-item-title">${item.title}</div>
                            <div class="search-item-desc">${item.description}</div>
                            <div class="search-item-meta">
                                <span class="badge badge-${item.color}">${item.status}</span>
                                <small class="text-muted ml-2">${item.meta}</small>
                            </div>
                        </div>
                    </a>
                `;
                    });
                }

                // Penalties
                if (results.penalties && results.penalties.length > 0) {
                    html += '<div class="search-header">Sanksi</div>';
                    results.penalties.forEach(function(item) {
                        hasResults = true;
                        html += `
                    <a href="${item.url}" class="search-item">
                        <div class="search-icon bg-${item.color} mr-3 text-white">
                            <i class="${item.icon}"></i>
                        </div>
                        <div class="search-item-content">
                            <div class="search-item-title">${item.title}</div>
                            <div class="search-item-desc">${item.description}</div>
                            <div class="search-item-meta">
                                <span class="badge badge-${item.color}">${item.status}</span>
                                <small class="text-muted ml-2">${item.meta}</small>
                            </div>
                        </div>
                    </a>
                `;
                    });
                }

                if (!hasResults) {
                    html = `<div class="text-center py-4 text-muted">
                        <i class="fas fa-search fa-2x mb-2"></i>
                        <div>Tidak ada hasil untuk "${query}"</div>
                        <small>Coba kata kunci yang lain</small>
                    </div>`;
                }

                $('#searchResultsContent').html(html);

                // Hide initial content when showing results
                $('#historiesHeader, #searchHistories, #quickAccess').hide();
            }

            function showInitialContent() {
                $('#searchResultsContent').html('');
                loadSearchHistories();
                loadQuickAccess();
            }

            function loadSearchHistories() {
                $.ajax({
                    url: '{{ route('search.global') }}',
                    method: 'GET',
                    data: {
                        q: ''
                    },
                    success: function(response) {
                        updateSearchHistories(response.histories);
                    }
                });
            }

            function updateSearchHistories(histories) {
                var html = '';

                if (histories && histories.length > 0) {
                    $('#historiesHeader').show();
                    histories.forEach(function(query) {
                        html += `
                    <div class="search-item history-item" data-query="${query}">
                        <div class="search-icon bg-secondary mr-3 text-white">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="search-item-content flex-grow-1">
                            <div class="search-item-title">${query}</div>
                        </div>
                        <a href="#" class="remove-history text-muted" data-query="${query}">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                `;
                    });
                } else {
                    $('#historiesHeader').hide();
                }

                $('#searchHistories').html(html);
            }

            function loadQuickAccess() {
                $('#quickAccess').show();
                $.ajax({
                    url: '{{ route('search.quick-access') }}',
                    method: 'GET',
                    success: function(response) {
                        var html = '';
                        response.quick_access.forEach(function(item) {
                            html += `
                        <a href="${item.url}" class="search-item">
                            <div class="search-icon bg-${item.color} mr-3 text-white">
                                <i class="${item.icon}"></i>
                            </div>
                            <div class="search-item-content">
                                <div class="search-item-title">${item.title}</div>
                            </div>
                        </a>
                    `;
                        });
                        $('#quickAccess').html(html);
                    },
                    error: function() {
                        $('#quickAccess').html(
                            '<div class="text-center py-2 text-muted">Gagal memuat akses cepat</div>'
                        );
                    }
                });
            }

            function removeSearchHistory(query) {
                $.ajax({
                    url: '{{ route('search.remove-history') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        query: query
                    },
                    success: function() {
                        loadSearchHistories();
                    }
                });
            }

            function clearSearchHistories() {
                $.ajax({
                    url: '{{ route('search.clear-history') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        $('#historiesHeader').hide();
                        $('#searchHistories').html('');
                    }
                });
            }
        });

        // Notification functions (same as before)
        function loadNotifications() {
            $.ajax({
                url: '{{ route('notifications.header') }}',
                method: 'GET',
                success: function(response) {
                    updateNotificationUI(response.notifications, response.unread_count);
                },
                error: function() {
                    $('#loadingNotifications').html(
                        '<div class="text-center text-muted py-3">Gagal memuat notifikasi</div>');
                }
            });
        }

        function updateNotificationUI(notifications, unreadCount) {
            // Update badge count
            if (unreadCount > 0) {
                $('#notificationCount').text(unreadCount).show();
                $('#notificationBell').addClass('beep');
            } else {
                $('#notificationCount').hide();
                $('#notificationBell').removeClass('beep');
            }

            // Update notification list
            var notificationHtml = '';

            if (notifications.length === 0) {
                notificationHtml = '<div class="text-center text-muted py-3">Tidak ada notifikasi</div>';
            } else {
                notifications.forEach(function(notification) {
                    var isUnread = notification.read_at === null;
                    var unreadClass = isUnread ? 'dropdown-item-unread' : '';

                    notificationHtml += `
                <a href="#" class="dropdown-item notification-item ${unreadClass}" 
                   data-id="${notification.id}" data-url="${notification.url}">
                    <div class="dropdown-item-icon bg-${notification.color} text-white">
                        <i class="${notification.icon}"></i>
                    </div>
                    <div class="dropdown-item-desc">
                        <strong>${notification.title}</strong>
                        <p>${notification.message}</p>
                        <div class="time">${notification.time_ago}</div>
                    </div>
                </a>
            `;
                });
            }

            $('#notificationList').html(notificationHtml);
            $('#loadingNotifications').hide();
        }

        function markAsRead(notificationId) {
            $.ajax({
                url: '{{ url('notifications') }}/' + notificationId + '/read',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update badge count
                    if (response.unread_count > 0) {
                        $('#notificationCount').text(response.unread_count).show();
                    } else {
                        $('#notificationCount').hide();
                        $('#notificationBell').removeClass('beep');
                    }
                }
            });
        }

        function markAllAsRead() {
            $.ajax({
                url: '{{ route('notifications.mark-all-read') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Hide badge
                    $('#notificationCount').hide();
                    $('#notificationBell').removeClass('beep');

                    // Remove unread class from all notifications
                    $('.notification-item').removeClass('dropdown-item-unread');

                    // Show success message (optional)
                    // You can add a toast notification here
                }
            });
        }
    </script>

    <style>
        .search-item {
            padding: 8px 15px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
            border-bottom: 1px solid #f0f0f0;
        }

        .search-item:hover {
            background-color: #f8f9fa;
            text-decoration: none;
            color: inherit;
        }

        .search-item:last-child {
            border-bottom: none;
        }

        .search-item-content {
            flex: 1;
            min-width: 0;
        }

        .search-item-title {
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-item-desc {
            font-size: 0.85em;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 2px;
        }

        .search-item-meta {
            font-size: 0.75em;
        }

        .search-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
        }

        .history-item {
            cursor: pointer;
        }

        .remove-history {
            padding: 5px;
            margin-left: 10px;
            opacity: 0.5;
            transition: opacity 0.2s;
        }

        .remove-history:hover {
            opacity: 1;
            color: #dc3545 !important;
            text-decoration: none;
        }

        .search-header {
            padding: 8px 15px;
            background-color: #f8f9fa;
            font-weight: 600;
            font-size: 0.85em;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .search-result {
            max-height: 400px;
            overflow-y: auto;
        }

        .search-element .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endpush
