<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Brand Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 20px;
            touch-action: manipulation;
        }

        .brand-table {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .brand-image-cell {
            width: 60px;
            height: 60px;
            overflow: hidden;
            margin-right: 15px;
        }

        .brand-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 4px;
        }

        .brand-name-container {
            display: flex;
            align-items: center;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .table > :not(caption) > * > * {
            vertical-align: middle;
        }

        .brand-card {
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        .brand-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .brand-card-body {
            margin-bottom: 10px;
        }

        .brand-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-rating-stars {
            font-size: 1rem;
        }

        .btn {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 767px) {
            body {
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .container {
                padding-left: 15px;
                padding-right: 15px;
                max-width: 100%;
            }

            .brand-name-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .brand-image-cell {
                margin-bottom: 10px;
                margin-right: 0;
                width: 50px;
                height: 50px;
            }

            .desktop-table {
                display: none;
            }

            .mobile-cards {
                display: block;
            }

            .action-buttons {
                justify-content: flex-start;
            }

            .btn {
                padding: 0.5rem 0.75rem;
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .form-control {
                min-height: 44px;
                font-size: 16px;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }
        }

        @media (min-width: 768px) {
            .mobile-cards {
                display: none;
            }

            .desktop-table {
                display: block;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8 col-sm-12 mb-2 mb-md-0">
            <h1 class="h2">Top Brands {{ $country ? 'in ' . $country->country_name : '' }}</h1>
        </div>
        <div class="col-md-4 col-sm-12 text-md-end">
            <button type="button" class="btn btn-primary w-100 w-md-auto" data-bs-toggle="modal"
                    data-bs-target="#createBrandModal">
                <i class="bi bi-plus-circle me-1"></i> Add New Brand
            </button>
        </div>
    </div>

    <div class="row">
        @if($brands->isEmpty())
            <div class="col-12">
                <div class="alert alert-info">
                    No brands found. Click "Add New Brand" to create one.
                </div>
            </div>
        @else
            <div class="col-12 desktop-table">
                <div class="table-responsive brand-table">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col" style="width:5%">#</th>
                            <th scope="col" style="width:45%">Brand</th>
                            <th scope="col" style="width:30%">Rating</th>
                            <th scope="col" style="width:20%; text-align: right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $index => $brand)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="brand-name-container">
                                        <div class="brand-image-cell">
                                            <img src="{{ $brand->brand_image }}" alt="{{ $brand->brand_name }}"
                                                 class="brand-image">
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $brand->brand_name }}</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 10; $i++)
                                            <i class="bi {{ $i <= $brand->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-sm btn-outline-primary edit-brand"
                                                data-id="{{ $brand->id }}"
                                                data-name="{{ $brand->brand_name }}"
                                                data-image="{{ $brand->brand_image }}"
                                                data-rating="{{ $brand->rating }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editBrandModal">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-brand"
                                                data-id="{{ $brand->id }}"
                                                data-name="{{ $brand->brand_name }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteBrandModal">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 mobile-cards">
                @foreach($brands as $index => $brand)
                    <div class="card brand-card">
                        <div class="brand-card-header">
                            <div class="brand-image-cell">
                                <img src="{{ $brand->brand_image }}" alt="{{ $brand->brand_name }}" class="brand-image">
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $brand->brand_name }}</h5>
                                <small class="text-muted">#{{ $index + 1 }}</small>
                            </div>
                        </div>
                        <div class="brand-card-body">
                            <div class="mobile-rating-stars">
                                @for($i = 1; $i <= 10; $i++)
                                    <i class="bi {{ $i <= $brand->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="brand-card-footer">
                            <div class="action-buttons">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-brand"
                                        data-id="{{ $brand->id }}"
                                        data-name="{{ $brand->brand_name }}"
                                        data-image="{{ $brand->brand_image }}"
                                        data-rating="{{ $brand->rating }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBrandModal">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-brand"
                                        data-id="{{ $brand->id }}"
                                        data-name="{{ $brand->brand_name }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteBrandModal">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBrandModalLabel">Add New Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createBrandForm">
                    <div class="mb-3">
                        <label for="createBrandName" class="form-label">Brand Name</label>
                        <input type="text" class="form-control" id="createBrandName" name="brand_name" required
                               autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="createBrandImage" class="form-label">Brand Image URL</label>
                        <input type="url" class="form-control" id="createBrandImage" name="brand_image" required
                               autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="createBrandRating" class="form-label">Rating (1-10)</label>
                        <input type="number" class="form-control" id="createBrandRating" name="rating" min="1" max="10"
                               required>
                    </div>
                </form>
            </div>
            <div class="modal-footer flex-wrap gap-2 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitCreateBrand">Create</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBrandForm">
                    <input type="hidden" id="editBrandId">
                    <div class="mb-3">
                        <label for="editBrandName" class="form-label">Brand Name</label>
                        <input type="text" class="form-control" id="editBrandName" name="brand_name" required
                               autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="editBrandImage" class="form-label">Brand Image URL</label>
                        <input type="url" class="form-control" id="editBrandImage" name="brand_image" required
                               autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="editBrandRating" class="form-label">Rating (1-10)</label>
                        <input type="number" class="form-control" id="editBrandRating" name="rating" min="1" max="10"
                               required>
                    </div>
                </form>
            </div>
            <div class="modal-footer flex-wrap gap-2 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitEditBrand">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteBrandModal" tabindex="-1" aria-labelledby="deleteBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBrandModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure you want to delete <strong><span
                                id="deleteBrandName"></span></strong>?</p>
                <input type="hidden" id="deleteBrandId">
            </div>
            <div class="modal-footer flex-wrap gap-2 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBrand">Delete</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('submitCreateBrand').addEventListener('click', function () {
            const form = document.getElementById('createBrandForm');
            const formData = new FormData(form);
            const brandData = {
                brand_name: formData.get('brand_name'),
                brand_image: formData.get('brand_image'),
                rating: parseInt(formData.get('rating'))
            };

            fetch('/api/brands', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(brandData)
            })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        if (data.errors) {
                            const errorMessages = Object.values(data.errors).flat();
                            throw new Error(errorMessages.join('\n'));
                        } else if (data.error) {
                            throw new Error(data.error);
                        } else {
                            throw new Error('An error occurred while creating the brand.');
                        }
                    }
                    return data;
                })
                .then(data => {
                    if ({{ $country ? 'true' : 'false' }}) {
                        return fetch('/api/countries/{{ $country ? $country->country_code : "" }}/brands', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                            },
                            body: JSON.stringify({
                                brand_id: data.id
                            })
                        }).then(async response => {
                            if (!response.ok) {
                                const errorData = await response.json();
                                if (errorData.errors) {
                                    const errorMessages = Object.values(errorData.errors).flat();
                                    throw new Error(errorMessages.join('\n'));
                                } else if (errorData.error) {
                                    throw new Error(errorData.error);
                                } else {
                                    throw new Error('An error occurred while associating brand with country.');
                                }
                            }
                            return response;
                        });
                    }
                    return Promise.resolve();
                })
                .then(() => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Failed to create brand. Please try again.');
                });
        });

        document.querySelectorAll('.edit-brand').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const image = this.getAttribute('data-image');
                const rating = this.getAttribute('data-rating');

                document.getElementById('editBrandId').value = id;
                document.getElementById('editBrandName').value = name;
                document.getElementById('editBrandImage').value = image;
                document.getElementById('editBrandRating').value = rating;
            });
        });

        document.getElementById('submitEditBrand').addEventListener('click', function () {
            const id = document.getElementById('editBrandId').value;
            const form = document.getElementById('editBrandForm');
            const formData = new FormData(form);
            const brandData = {
                brand_name: formData.get('brand_name'),
                brand_image: formData.get('brand_image'),
                rating: parseInt(formData.get('rating'))
            };

            fetch(`/api/brands/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(brandData)
            })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        if (data.errors) {
                            // Format validation errors
                            const errorMessages = Object.values(data.errors).flat();
                            throw new Error(errorMessages.join('\n'));
                        } else if (data.error) {
                            throw new Error(data.error);
                        } else {
                            throw new Error('An error occurred while updating the brand.');
                        }
                    }
                    return data;
                })
                .then(() => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Failed to update brand. Please try again.');
                });
        });

        document.querySelectorAll('.delete-brand').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                document.getElementById('deleteBrandId').value = id;
                document.getElementById('deleteBrandName').textContent = name;
            });
        });

        document.getElementById('confirmDeleteBrand').addEventListener('click', function () {
            const id = document.getElementById('deleteBrandId').value;

            fetch(`/api/brands/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            })
                .then(async response => {
                    if (!response.ok) {
                        try {
                            const errorData = await response.json();
                            if (errorData.errors) {
                                const errorMessages = Object.values(errorData.errors).flat();
                                throw new Error(errorMessages.join('\n'));
                            } else if (errorData.error) {
                                throw new Error(errorData.error);
                            } else {
                                throw new Error('An error occurred while deleting the brand.');
                            }
                        } catch (e) {
                            throw new Error('An error occurred while deleting the brand.');
                        }
                    }
                    return response;
                })
                .then(() => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Failed to delete brand. Please try again.');
                });
        });
    });
</script>
</body>
</html>