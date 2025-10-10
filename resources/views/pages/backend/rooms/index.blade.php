@extends('layouts.backend.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createRoomModal">
        Create Office
      </button>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table Office</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Office Name</th>
            <th class="text-white">Rooms</th>
            <th class="text-white">Barcode</th>
            <th class="text-white">Testing</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rooms as $room)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td><strong>{{ $room->name }}</strong></td>
            <td>
                <span class="badge bg-primary">{{ $room->roomDetails->count() }} Room(s)</span>
                <button type="button" class="btn btn-sm btn-outline-primary ms-1" data-bs-toggle="modal" data-bs-target="#manageRoomsModal"
                        onclick="manageRooms({{ $room->id }}, '{{ addslashes($room->name) }}', {{ $room->roomDetails }})">
                  <i class="fas fa-cog"></i> Manage
                </button>
            </td>
            <td>
                <a href="{{ route('rooms.barcode', $room->id) }}" class="btn btn-info btn-sm" target="_blank">
                  <i class="fas fa-qrcode"></i> Print Barcode
                </a>
            </td>
            <td>
                <a href="{{ route('transaction', $room->id) }}" class="btn btn-success btn-sm" target="_blank">
                  <i class="fas fa-external-link-alt"></i> Test Link
                </a>
            </td>
            <td>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRoomModal"
                        onclick="editRoom({{ $room->id }}, '{{ addslashes($room->name) }}')">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</button>
                </form>
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- / Content -->

<!-- Create Office Modal -->
<div class="modal fade" id="createRoomModal" tabindex="-1" aria-labelledby="createRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createRoomModalLabel">Create New Office</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="create_name" class="form-label">Office Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="create_name" name="name" value="{{ old('name') }}" required placeholder="e.g., Sales Office, Marketing Office">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Office</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Office Modal -->
<div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoomModalLabel">Edit Office</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editRoomForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_name" class="form-label">Office Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name" placeholder="e.g., Sales Office, Marketing Office">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Office</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Manage Rooms Modal -->
<div class="modal fade" id="manageRoomsModal" tabindex="-1" aria-labelledby="manageRoomsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="manageRoomsModalLabel">
          <i class="fas fa-door-open"></i> Manage Rooms for <span id="manage_office_name"></span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addRoomDetailModal">
            <i class="fas fa-plus"></i> Add Room
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Room Name</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="roomDetailsList">
              <!-- Will be populated by JavaScript -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Room Detail Modal -->
<div class="modal fade" id="addRoomDetailModal" tabindex="-1" aria-labelledby="addRoomDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRoomDetailModalLabel">Add New Room</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addRoomDetailForm" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="room_detail_name" class="form-label">Room Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="room_detail_name" name="name" required placeholder="e.g., Meeting Room 1, Work Space A">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Room</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Room Detail Modal -->
<div class="modal fade" id="editRoomDetailModal" tabindex="-1" aria-labelledby="editRoomDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoomDetailModalLabel">Edit Room</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editRoomDetailForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_room_detail_name" class="form-label">Room Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="edit_room_detail_name" name="name" required placeholder="e.g., Meeting Room 1, Work Space A">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Room</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
let currentRoomId = null;

function editRoom(id, name) {
  // Set form action
  document.getElementById('editRoomForm').action = `/rooms/${id}`;

  // Set form values
  document.getElementById('edit_name').value = name;
}

function manageRooms(roomId, roomName, roomDetails) {
  currentRoomId = roomId;

  // Set office name in modal title
  document.getElementById('manage_office_name').textContent = roomName;

  // Set form action for add room detail
  document.getElementById('addRoomDetailForm').action = `/rooms/${roomId}/details`;

  // Populate room details list
  const tbody = document.getElementById('roomDetailsList');
  tbody.innerHTML = '';

  if (roomDetails && roomDetails.length > 0) {
    roomDetails.forEach((detail, index) => {
      tbody.innerHTML += `
        <tr>
          <td>${index + 1}</td>
          <td><strong>${detail.name}</strong></td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" onclick="editRoomDetail(${detail.id}, '${detail.name.replace(/'/g, "\\'")}')">
              <i class="fas fa-edit"></i> Edit
            </button>
            <form action="/room-details/${detail.id}" method="POST" style="display:inline-block;">
              <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'}">
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                <i class="fas fa-trash"></i> Delete
              </button>
            </form>
          </td>
        </tr>
      `;
    });
  } else {
    tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">No rooms yet. Click "Add Room" to create one.</td></tr>';
  }
}

function editRoomDetail(detailId, detailName) {
  // Close manage modal and open edit modal
  const manageModal = bootstrap.Modal.getInstance(document.getElementById('manageRoomsModal'));
  manageModal.hide();

  setTimeout(() => {
    // Set form action
    document.getElementById('editRoomDetailForm').action = `/room-details/${detailId}`;

    // Set form values
    document.getElementById('edit_room_detail_name').value = detailName;

    // Show edit modal
    const editModal = new bootstrap.Modal(document.getElementById('editRoomDetailModal'));
    editModal.show();
  }, 300);
}

// Reset form when add modal is closed
document.getElementById('addRoomDetailModal').addEventListener('hidden.bs.modal', function () {
  document.getElementById('room_detail_name').value = '';
});

// Reset form when edit modal is closed
document.getElementById('editRoomDetailModal').addEventListener('hidden.bs.modal', function () {
  document.getElementById('edit_room_detail_name').value = '';
});
</script>
@endsection
