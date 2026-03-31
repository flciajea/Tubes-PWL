@extends('layouts.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <!-- Page Header -->
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Event Management</h3>
                <h6 class="op-7 mb-2">Manage all your events in one place</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('events.create') }}" class="btn btn-primary btn-round">
                    <i class="fas fa-plus"></i> Create New Event
                </a>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="searchEvent"
                                        placeholder="Search events..."
                                    />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="filterCategory">
                                    <option value="">All Categories</option>
                                    <option value="music">Music</option>
                                    <option value="sports">Sports</option>
                                    <option value="conference">Conference</option>
                                    <option value="workshop">Workshop</option>
                                    <option value="seminar">Seminar</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="filterStatus">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Events</p>
                                    <h4 class="card-title">{{ $events->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Active Events</p>
                                    <h4 class="card-title">{{ $events->where('status', 'active')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Draft Events</p>
                                    <h4 class="card-title">{{ $events->where('status', 'draft')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Quota</p>
                                    <h4 class="card-title">{{ $events->sum('total_quotas') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Toggle -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" id="cardViewBtn" onclick="switchView('card')">
                        <i class="fas fa-th-large"></i> Card View
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="tableViewBtn" onclick="switchView('table')">
                        <i class="fas fa-table"></i> Table View
                    </button>
                </div>
            </div>
        </div>

        <!-- Card View (Default) -->
        <div id="cardView">
            <div class="row" id="eventCards">
                @forelse($events as $event)
                    <div class="col-md-6 col-lg-4 mb-4 event-card" 
                         data-title="{{ strtolower($event->title) }}"
                         data-category="{{ $event->category->name ?? '' }}"
                         data-status="{{ $event->status }}">
                        <div class="card card-post card-round h-100">
                            <!-- Event Banner -->
                            <img 
                                class="card-img-top" 
                                src="{{ asset('storage/' . $event->banner) }}" 
                                alt="{{ $event->title }}"
                                style="height: 200px; object-fit: cover;"
                            />
                            
                            <!-- Status Badge -->
                            <div class="position-absolute top-0 end-0 m-3">
                                @if($event->status === 'active')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Active
                                    </span>
                                @elseif($event->status === 'draft')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-file"></i> Draft
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times"></i> Inactive
                                    </span>
                                @endif
                            </div>

                            <div class="card-body">
                                <!-- Category -->
                                <div class="d-flex mb-2">
                                    <span class="badge badge-primary">
                                        {{ $event->category->name ?? 'Uncategorized' }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h4 class="card-title">
                                    <a href="#" class="text-decoration-none text-dark">
                                        {{ Str::limit($event->title, 50) }}
                                    </a>
                                </h4>

                                <!-- Description -->
                                <p class="card-text text-muted">
                                    {{ Str::limit($event->description, 100) }}
                                </p>

                                <!-- Event Info -->
                                <div class="separator-solid mb-3"></div>
                                
                                <div class="mb-2">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                    <small class="ms-2">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</small>
                                </div>
                                
                                <div class="mb-2">
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                    <small class="ms-2">{{ Str::limit($event->location, 30) }}</small>
                                </div>
                                
                                <div class="mb-3">
                                    <i class="fas fa-users text-success"></i>
                                    <small class="ms-2">Quota: {{ $event->total_quotas }} participants</small>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-primary btn-sm flex-fill">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm flex-fill">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteEvent({{ $event->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-calendar-times fa-5x text-muted mb-3"></i>
                                <h4 class="text-muted">No Events Found</h4>
                                <p class="text-muted">Start by creating your first event!</p>
                                <a href="{{ route('events.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create Event
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Table View (Hidden by default) -->
        <div id="tableView" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="eventsTable">
                            <thead>
                                <tr>
                                    <th width="100">Banner</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Quota</th>
                                    <th>Status</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                    <tr class="event-row"
                                        data-title="{{ strtolower($event->title) }}"
                                        data-category="{{ $event->category->name ?? '' }}"
                                        data-status="{{ $event->status }}">
                                        <td>
                                            <img 
                                                src="{{ asset('storage/' . $event->banner) }}" 
                                                width="80" 
                                                class="img-thumbnail"
                                                alt="{{ $event->title }}"
                                            />
                                        </td>
                                        <td>
                                            <strong>{{ $event->title }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($event->description, 60) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ $event->category->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                                        <td>{{ Str::limit($event->location, 30) }}</td>
                                        <td>
                                            <i class="fas fa-users"></i> {{ $event->total_quotas }}
                                        </td>
                                        <td>
                                            @if($event->status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($event->status === 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="#" class="btn btn-sm btn-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                               <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm flex-fill">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger" onclick="deleteEvent({{ $event->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ExtraCSS')
<style>
    .card-post {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .card-post:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .card-stats {
        transition: transform 0.3s ease;
    }

    .card-stats:hover {
        transform: translateY(-5px);
    }

    .bubble-shadow-small {
        box-shadow: 0px 2px 20px 0px rgba(0, 0, 0, 0.1);
    }

    .badge {
        font-size: 11px;
        padding: 5px 10px;
    }

    .btn-group .btn {
        padding: 5px 10px;
    }

    .separator-solid {
        border-top: 1px solid #eee;
    }

    .img-thumbnail {
        border-radius: 8px;
    }

    .card-img-top {
        border-radius: 8px 8px 0 0;
    }

    .event-card, .event-row {
        transition: opacity 0.3s ease;
    }

    .event-card.hidden, .event-row.hidden {
        display: none !important;
    }
</style>
@endsection

@section('ExtraJS')
<script>
    $(document).ready(function() {
        // Initialize DataTable for table view
        if ($('#eventsTable').length) {
            $('#eventsTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": false, // We use custom search
                "info": true,
                "lengthChange": true
            });
        }

        // Search functionality
        $('#searchEvent').on('keyup', function() {
            filterEvents();
        });

        $('#filterCategory, #filterStatus').on('change', function() {
            filterEvents();
        });
    });

    // Filter events
    function filterEvents() {
        const searchTerm = $('#searchEvent').val().toLowerCase();
        const category = $('#filterCategory').val().toLowerCase();
        const status = $('#filterStatus').val().toLowerCase();

        $('.event-card, .event-row').each(function() {
            const title = $(this).data('title');
            const eventCategory = $(this).data('category').toLowerCase();
            const eventStatus = $(this).data('status').toLowerCase();

            const matchSearch = title.includes(searchTerm);
            const matchCategory = !category || eventCategory.includes(category);
            const matchStatus = !status || eventStatus === status;

            if (matchSearch && matchCategory && matchStatus) {
                $(this).removeClass('hidden').fadeIn();
            } else {
                $(this).addClass('hidden').fadeOut();
            }
        });
    }

    // Reset filters
    function resetFilters() {
        $('#searchEvent').val('');
        $('#filterCategory').val('');
        $('#filterStatus').val('');
        $('.event-card, .event-row').removeClass('hidden').fadeIn();
    }

    // Switch between card and table view
    function switchView(view) {
        if (view === 'card') {
            $('#cardView').fadeIn();
            $('#tableView').fadeOut();
            $('#cardViewBtn').addClass('active');
            $('#tableViewBtn').removeClass('active');
        } else {
            $('#cardView').fadeOut();
            $('#tableView').fadeIn();
            $('#cardViewBtn').removeClass('active');
            $('#tableViewBtn').addClass('active');
        }
    }

    // Delete event
    function deleteEvent(eventId) {
        swal({
            title: "Are you sure?",
            text: "This event will be permanently deleted!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, delete it!",
                    value: true,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true
                }
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // AJAX delete request
                $.ajax({
                    url: "{{ url('/admin/events') }}/" + eventId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        swal("Deleted!", "Event has been deleted.", "success")
                            .then(() => {
                                location.reload();
                            });
                    },
                    error: function(xhr) {
                        swal("Error!", "Failed to delete event.", "error");
                    }
                });
            }
        });
    }
</script>
@endsectio