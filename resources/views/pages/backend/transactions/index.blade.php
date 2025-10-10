@extends('layouts.backend.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mt-2">
    <h5 class="card-header">Table Transactions</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">User</th>
            <th class="text-white">Office</th>
            <th class="text-white">Location</th>
            <th class="text-white">Status</th>
            <th class="text-white">Items</th>
            <th class="text-white">Created At</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $transaction)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $transaction->user->name }}</td>
            <td>
              @if($transaction->room)
                <span class="badge bg-primary">{{ $transaction->room->name }}</span>
              @else
                <span class="badge bg-secondary">No Room</span>
              @endif
            </td>
            <td>
              <span class="badge bg-info">{{ $transaction->location }}</span>
            </td>
            <td>
              @if($transaction->status == 'pending')
                <span class="badge bg-warning">Pending</span>
              @elseif($transaction->status == 'process')
                <span class="badge bg-info">Process</span>
              @elseif($transaction->status == 'completed')
                <span class="badge bg-success">Completed</span>
              @elseif($transaction->status == 'cancel')
                <span class="badge bg-danger">Canceled</span>
              @endif
            </td>
            <td>
              <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewDetailsModal"
                      onclick="viewDetails({{ $transaction->id }}, '{{ $transaction->user->name }}', '{{ $transaction->room ? $transaction->room->name : 'No Room' }}', '{{ $transaction->location }}', '{{ $transaction->status }}', {{ $transaction->transactionDetails->toJson() }})">
                View Items ({{ $transaction->transactionDetails->count() }})
              </button>
            </td>
            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStatusModal"
                        onclick="editStatus({{ $transaction->id }}, '{{ $transaction->status }}')">
                  Update Status
                </button>
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- / Content -->

<!-- View Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewDetailsModalLabel">Transaction Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-3">
            <strong>User:</strong> <span id="detail_user"></span>
          </div>
          <div class="col-md-3">
            <strong>Office:</strong> <span id="detail_room"></span>
          </div>
          <div class="col-md-3">
            <strong>Location:</strong> <span id="detail_location"></span>
          </div>
          <div class="col-md-3">
            <strong>Status:</strong> <span id="detail_status"></span>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Menu</th>
                <th>Employee</th>
                <th>Variant</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody id="detail_items">
              <!-- Items will be populated by JavaScript -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStatusModalLabel">Update Transaction Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editStatusForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_status" class="form-label">Status</label>
            <select class="form-control @error('status') is-invalid @enderror" id="edit_status" name="status" onchange="toggleResponsiblePerson()">
              <option value="pending">Pending</option>
              <option value="process">Process</option>
              <option value="completed">Completed</option>
              <option value="cancel">Cancel</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3" id="responsible_person_div" style="display: none;">
            <label for="responsible_person" class="form-label">Penanggung Jawab</label>
            <select class="form-control @error('responsible_person') is-invalid @enderror" id="responsible_person" name="responsible_person">
              <option value="">Pilih Penanggung Jawab</option>
              @foreach(\App\Models\User::where('name', '!=', 'Admin')->get() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
            @error('responsible_person')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Status</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function viewDetails(id, userName, roomName, location, status, items) {
  // Set detail information
  document.getElementById('detail_user').textContent = userName;
  document.getElementById('detail_room').textContent = roomName;
  document.getElementById('detail_location').textContent = location;

  // Set status badge
  let statusBadge = '';
  if (status === 'pending') {
    statusBadge = '<span class="badge bg-warning">Pending</span>';
  } else if (status === 'process') {
    statusBadge = '<span class="badge bg-info">Process</span>';
  } else if (status === 'completed') {
    statusBadge = '<span class="badge bg-success">Completed</span>';
  } else if (status === 'cancel') {
    statusBadge = '<span class="badge bg-danger">Canceled</span>';
  }
  document.getElementById('detail_status').innerHTML = statusBadge;

  // Populate items table
  let itemsHtml = '';
  items.forEach(function(item) {
    // Format variant label
    let variantLabel = '';
    if (item.variant === 'less_sugar') {
      variantLabel = '<span class="badge bg-warning">🙂 Kurang Manis</span>';
    } else if (item.variant === 'normal') {
      variantLabel = '<span class="badge bg-info">😊 Normal</span>';
    } else if (item.variant === 'no_sugar') {
      variantLabel = '<span class="badge bg-secondary">🚫 Tanpa Gula</span>';
    } else {
      variantLabel = '<span class="badge bg-light text-dark">-</span>';
    }

    itemsHtml += '<tr>';
    itemsHtml += '<td>' + item.menu.name + '</td>';
    itemsHtml += '<td><span class="badge bg-success">' + (item.employee || '-') + '</span></td>';
    itemsHtml += '<td>' + variantLabel + '</td>';
    itemsHtml += '<td><span class="badge bg-primary">' + item.quantity + 'x</span></td>';
    itemsHtml += '</tr>';
  });
  document.getElementById('detail_items').innerHTML = itemsHtml;
}

function editStatus(id, currentStatus) {
  // Set form action
  document.getElementById('editStatusForm').action = `/transactions/${id}`;

  // Set current status
  document.getElementById('edit_status').value = currentStatus;

  // Reset responsible person dropdown
  document.getElementById('responsible_person').value = '';
  toggleResponsiblePerson();
}

function toggleResponsiblePerson() {
  const statusSelect = document.getElementById('edit_status');
  const responsibleDiv = document.getElementById('responsible_person_div');

  if (statusSelect.value === 'process') {
    responsibleDiv.style.display = 'block';
    document.getElementById('responsible_person').required = true;
  } else {
    responsibleDiv.style.display = 'none';
    document.getElementById('responsible_person').required = false;
  }
}
</script>
@endsection
