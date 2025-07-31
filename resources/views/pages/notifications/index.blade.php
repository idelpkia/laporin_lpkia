@extends('layouts.app')

@section('title', 'Notifikasi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Notifikasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Notifikasi</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Semua Notifikasi</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-primary" id="markAllRead">
                                        <i class="fas fa-check"></i> Tandai Semua Dibaca
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if ($notifications->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Judul</th>
                                                    <th>Pesan</th>
                                                    <th>Waktu</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($notifications as $notification)
                                                    <tr class="{{ $notification->read_at ? '' : 'table-warning' }}">
                                                        <td>
                                                            @if ($notification->read_at)
                                                                <i class="fas fa-envelope-open text-muted"></i>
                                                            @else
                                                                <i class="fas fa-envelope text-primary"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="notification-icon bg-{{ $notification->type == 'new_report' ? 'primary' : ($notification->type == 'investigation_started' ? 'warning' : ($notification->type == 'appeal_submitted' ? 'info' : 'success')) }} text-white mr-2">
                                                                    <i
                                                                        class="fas fa-{{ $notification->type == 'new_report' ? 'file-alt' : ($notification->type == 'investigation_started' ? 'search' : ($notification->type == 'appeal_submitted' ? 'gavel' : 'bell')) }}"></i>
                                                                </div>
                                                                <div>
                                                                    <strong>{{ $notification->title }}</strong>
                                                                    @if (!$notification->read_at)
                                                                        <span
                                                                            class="badge badge-danger badge-sm ml-1">Baru</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-1">{{ Str::limit($notification->message, 80) }}
                                                            </p>
                                                            @if ($notification->report)
                                                                <small class="text-muted">
                                                                    <i class="fas fa-link"></i>
                                                                    Terkait:
                                                                    {{ Str::limit($notification->report->title ?? 'Laporan #' . $notification->report_id, 30) }}
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div>{{ $notification->created_at->format('d/m/Y H:i') }}</div>
                                                            <small
                                                                class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a href="#" data-toggle="dropdown"
                                                                    class="btn btn-outline-primary btn-sm">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                    @if (!$notification->read_at)
                                                                        <a href="#" class="dropdown-item mark-read"
                                                                            data-id="{{ $notification->id }}">
                                                                            <i class="fas fa-check"></i> Tandai Dibaca
                                                                        </a>
                                                                    @endif
                                                                    @if ($notification->report_id)
                                                                        <a href="{{ route('reports.show', $notification->report_id) }}"
                                                                            class="dropdown-item">
                                                                            <i class="fas fa-eye"></i> Lihat Laporan
                                                                        </a>
                                                                    @endif
                                                                    <div class="dropdown-divider"></div>
                                                                    <a href="#"
                                                                        class="dropdown-item text-danger delete-notification"
                                                                        data-id="{{ $notification->id }}">
                                                                        <i class="fas fa-trash"></i> Hapus
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-center">
                                            {{ $notifications->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="empty-state" data-height="400">
                                        <div class="empty-state-icon bg-primary">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        <h2>Tidak ada notifikasi</h2>
                                        <p class="lead">
                                            Anda belum memiliki notifikasi apapun. Notifikasi akan muncul ketika ada
                                            aktivitas terkait laporan Anda.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Notifikasi</h4>
                                </div>
                                <div class="card-body">
                                    {{ $notifications->total() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Belum Dibaca</h4>
                                </div>
                                <div class="card-body">
                                    {{ \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at')->count() }}
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
            // Mark individual notification as read
            $('.mark-read').on('click', function(e) {
                e.preventDefault();
                var notificationId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    url: '{{ url('notifications') }}/' + notificationId + '/read',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        row.removeClass('table-warning');
                        row.find('.fa-envelope').removeClass('text-primary').addClass(
                            'text-muted');
                        row.find('.fa-envelope').removeClass('fa-envelope').addClass(
                            'fa-envelope-open');
                        row.find('.badge-danger').remove();

                        // Update unread count in statistics
                        var unreadCard = $('.card-statistic-1').last().find('.card-body');
                        var currentCount = parseInt(unreadCard.text());
                        unreadCard.text(Math.max(0, currentCount - 1));

                        // Remove mark as read button
                        $(this).closest('.dropdown-item').remove();
                    }
                });
            });

            // Mark all notifications as read
            $('#markAllRead').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('notifications.mark-all-read') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Remove warning highlighting from all rows
                        $('tr.table-warning').removeClass('table-warning');

                        // Update all envelope icons
                        $('.fa-envelope.text-primary').removeClass('text-primary fa-envelope')
                            .addClass('text-muted fa-envelope-open');

                        // Remove all "Baru" badges
                        $('.badge-danger').remove();

                        // Update unread count to 0
                        $('.card-statistic-1').last().find('.card-body').text('0');

                        // Remove all mark as read buttons
                        $('.mark-read').parent().remove();

                        // Show success message
                        alert('Semua notifikasi telah ditandai sebagai dibaca');
                    }
                });
            });

            // Delete notification
            $('.delete-notification').on('click', function(e) {
                e.preventDefault();
                var notificationId = $(this).data('id');
                var row = $(this).closest('tr');

                if (confirm('Yakin ingin menghapus notifikasi ini?')) {
                    $.ajax({
                        url: '{{ url('notifications') }}/' + notificationId,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            row.fadeOut(300, function() {
                                $(this).remove();

                                // Check if table is empty
                                if ($('tbody tr').length === 0) {
                                    location.reload();
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>

    <style>
        .notification-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .table-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: white;
            margin-bottom: 20px;
        }
    </style>
@endpush
