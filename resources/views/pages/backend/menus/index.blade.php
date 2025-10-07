@extends('layouts.backend.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createMenuModal">
        Create Menu
      </button>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table Menu</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Name</th>
            <th class="text-white">Available</th>
            <th class="text-white">Image</th>
            <th class="text-white">Descriptions</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($menus as $menu)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $menu->name }}</td>
            <td>
              @if($menu->is_available)
                <span class="badge bg-success">Available</span>
              @else
                <span class="badge bg-danger">Not Available</span>
              @endif
            </td>
            <td>
              @if($menu->image)
                <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" style="max-width: 50px; max-height: 50px;">
              @else
                <span class="text-muted">No Image</span>
              @endif
            </td>
            <td>{{ Str::limit($menu->descriptions, 50) }}</td>
            <td>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMenuModal"
                        onclick="editMenu({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->is_available ? 'true' : 'false' }}, '{{ $menu->descriptions }}')">
                  Edit
                </button>
                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
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

<!-- Create Menu Modal -->
<div class="modal fade" id="createMenuModal" tabindex="-1" aria-labelledby="createMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createMenuModalLabel">Create New Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="create_name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="create_name" name="name" value="{{ old('name') }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="create_is_available" class="form-label">Available</label>
            <select class="form-control @error('is_available') is-invalid @enderror" id="create_is_available" name="is_available">
              <option value="1" {{ old('is_available') == '1' ? 'selected' : '' }}>Available</option>
              <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Not Available</option>
            </select>
            @error('is_available')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="create_image" class="form-label">Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="create_image" name="image" accept="image/*">
            @error('image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="create_descriptions" class="form-label">Descriptions</label>
            <textarea class="form-control @error('descriptions') is-invalid @enderror" id="create_descriptions" name="descriptions" rows="3">{{ old('descriptions') }}</textarea>
            @error('descriptions')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Menu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editMenuForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="edit_is_available" class="form-label">Available</label>
            <select class="form-control @error('is_available') is-invalid @enderror" id="edit_is_available" name="is_available">
              <option value="1">Available</option>
              <option value="0">Not Available</option>
            </select>
            @error('is_available')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="edit_image" class="form-label">Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="edit_image" name="image" accept="image/*">
            @error('image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="edit_descriptions" class="form-label">Descriptions</label>
            <textarea class="form-control @error('descriptions') is-invalid @enderror" id="edit_descriptions" name="descriptions" rows="3"></textarea>
            @error('descriptions')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Menu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function editMenu(id, name, isAvailable, descriptions) {
  // Set form action
  document.getElementById('editMenuForm').action = `/menus/${id}`;

  // Set form values
  document.getElementById('edit_name').value = name;
  document.getElementById('edit_is_available').value = isAvailable ? '1' : '0';
  document.getElementById('edit_descriptions').value = descriptions;

  // Clear image field
  document.getElementById('edit_image').value = '';
}
</script>
@endsection
