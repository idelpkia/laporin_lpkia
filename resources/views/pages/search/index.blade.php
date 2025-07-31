@extends('layouts.app')

@section('title', 'Pencarian Lanjutan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pencarian Lanjutan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Pencarian</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Search Form -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Filter Pencarian</h4>
                            </div>
                            <div class="card-body">
                                <form id="advancedSearchForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kata Kunci</label>
                                                <input type="text" class="form-control" name="keyword" id="searchKeyword"
                                                    placeholder="Masukkan kata kunci..." value="{{ request('q') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="form-control" name="category" id="searchCategory">
                                                    <option value="">Semua Kategori</option>
                                                    <option value="reports">Laporan</option>
                                                    <option value="users">Pengguna</option>
                                                    <option value="investigations">Investigasi</option>
                                                    <option value="appeals">Banding</option>
                                                    <option value="penalties">Sanksi</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status" id="searchStatus">
                                                    <option value="">Semua Status</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">Dalam Proses</option>
                                                    <option value="completed">Selesai</option>
                                                    <option value="rejected">Ditolak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Rentang Tanggal</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" name="date_from"
                                                        id="dateFrom">
                                                    <div class="input-group-prepend input-group-append">
                                                        <span class="input-group-text">s/d</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="date_to"
                                                        id="dateTo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                            <button type="button" class="btn btn-secondary ml-2" id="resetForm">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Results -->
                <div class="row" id="searchResultsSection" style="display: none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Hasil Pencarian</h4>
                                <div class="card-header-action">
                                    <span class="badge badge-primary" id="resultCount">0 hasil</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="searchResultsContainer">
                                    <!-- Results will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading State -->
                <div class="row" id="loadingSection" style="display: none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                                <div>Mencari data...</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Searches -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pencarian Terkini</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-sm btn-outline-danger" id="clearAllHistory">
                                        <i class="fas fa-trash"></i> Hapus Semua
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="recentSearches">
                                    <div class="text-muted text-center py-3">
                                        Belum ada riwayat pencarian
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Load recent searches on page load
            loadRecentSearches();

            // Check if there's a query parameter and perform search
            var urlQuery = new URLSearchParams(window.location.search).get('q');
            if (urlQuery) {
                $('#searchKeyword').val(urlQuery);
                performAdvancedSearch();
            }

            // Handle form submission
            $('#advancedSearchForm').on('submit', function(e) {
                e.preventDefault();
                performAdvancedSearch();
            });

            // Handle reset button
            $('#resetForm').on('click', function() {
                $('#advancedSearchForm')[0].reset();
                $('#searchResultsSection').hide();
                loadRecentSearches();
            });

            // Handle clear all history
            $('#clearAllHistory').on('click', function() {
                if (confirm('Yakin ingin menghapus semua riwayat pencarian?')) {
                    clearAllSearchHistory();
                }
            });

            function performAdvancedSearch() {
                var formData = {
                    q: $('#searchKeyword').val(),
                    category: $('#searchCategory').val(),
                    status: $('#searchStatus').val(),
                    date_from: $('#dateFrom').val(),
                    date_to: $('#dateTo').val()
                };

                // Show loading
                $('#searchResultsSection').hide();
                $('#loadingSection').show();

                $.ajax({
                    url: '{{ route('search.global') }}',
                    method: 'GET',
                    data: formData,
                    success: function(response) {
                        displayAdvancedResults(response);
                        $('#loadingSection').hide();
                        $('#searchResultsSection').show();
                        loadRecentSearches();
                    },
                    error: function() {
                        $('#loadingSection').hide();
                        showError('Terjadi kesalahan saat mencari data');
                    }
                });
            }

            function displayAdvancedResults(response) {
                var html = '';
                var totalResults = 0;

                // Count total results
                Object.keys(response.results).forEach(function(key) {
                    if (response.results[key] && response.results[key].length > 0) {
                        totalResults += response.results[key].length;
                    }
                });

                $('#resultCount').text(totalResults + ' hasil');

                if (totalResults === 0) {
                    html = `
                <div class="empty-state" style="padding: 60px 20px; text-align: center;">
                    <div class="empty-state-icon bg-secondary" style="width: 80px; height: 80px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 30px; color: white; margin-bottom: 20px;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h2>Tidak ada hasil</h2>
                    <p class="lead">Coba ubah kata kunci atau filter pencarian Anda</p>
                </div>
            `;
                } else {
                    // Display results by category
                    ['reports', 'users', 'investigations', 'appeals', 'penalties'].forEach(function(category) {
                        if (response.results[category] && response.results[category].length > 0) {
                            html += `<div class="list-group-item list-group-item-action flex-column align-items-start p-3 bg-light">
                                <h6 class="mb-0">${getCategoryTitle(category)} (${response.results[category].length})</h6>
                             </div>`;

                            response.results[category].forEach(function(item) {
                                html += `
                            <a href="${item.url}" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <div class="search-result-icon bg-${item.color} text-white mr-3">
                                            <i class="${item.icon}"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">${item.title}</h6>
                                            <p class="mb-1 text-muted">${item.description}</p>
                                            <small class="text-muted">${item.meta}</small>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        ${item.status ? `<span class="badge badge-${item.color}">${item.status}</span>` : ''}
                                    </div>
                                </div>
                            </a>
                        `;
                            });
                        }
                    });
                }

                $('#searchResultsContainer').html('<div class="list-group">' + html + '</div>');
            }

            function getCategoryTitle(category) {
                const titles = {
                    'reports': 'Laporan',
                    'users': 'Pengguna',
                    'investigations': 'Investigasi',
                    'appeals': 'Banding',
                    'penalties': 'Sanksi'
                };
                return titles[category] || category;
            }

            function loadRecentSearches() {
                // This would typically load from server, but for now we'll use local storage
                var searches = JSON.parse(localStorage.getItem('recentSearches') || '[]');

                if (searches.length === 0) {
                    $('#recentSearches').html(
                        '<div class="text-muted text-center py-3">Belum ada riwayat pencarian</div>');
                    return;
                }

                var html = '';
                searches.forEach(function(search) {
                    html += `
                <span class="badge badge-secondary mr-2 mb-2 recent-search-item" style="cursor: pointer; font-size: 0.9em;">
                    <i class="fas fa-search mr-1"></i> ${search}
                    <i class="fas fa-times ml-1 remove-recent" data-search="${search}"></i>
                </span>
            `;
                });

                $('#recentSearches').html(html);
            }

            // Handle recent search clicks
            $(document).on('click', '.recent-search-item', function(e) {
                if ($(e.target).hasClass('remove-recent')) return;

                var searchTerm = $(this).text().trim();
                $('#searchKeyword').val(searchTerm);
                performAdvancedSearch();
            });

            // Handle remove recent search
            $(document).on('click', '.remove-recent', function(e) {
                e.stopPropagation();
                var searchTerm = $(this).data('search');
                removeRecentSearch(searchTerm);
            });

            function removeRecentSearch(searchTerm) {
                var searches = JSON.parse(localStorage.getItem('recentSearches') || '[]');
                searches = searches.filter(function(search) {
                    return search !== searchTerm;
                });
                localStorage.setItem('recentSearches', JSON.stringify(searches));
                loadRecentSearches();
            }

            function clearAllSearchHistory() {
                localStorage.removeItem('recentSearches');
                loadRecentSearches();
            }

            function showError(message) {
                $('#searchResultsContainer').html(`
            <div class="alert alert-danger m-3">
                <i class="fas fa-exclamation-triangle mr-2"></i> ${message}
            </div>
        `);
                $('#searchResultsSection').show();
            }
        });
    </script>

    <style>
        .search-result-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .recent-search-item:hover {
            background-color: #6c757d !important;
        }

        .remove-recent:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush
