@extends('layouts.master')
@section('title', 'Products')
@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Products</h2>
            </div>
            <div class="card-body">
                <!-- Filter Section -->
                <form action="{{ route('products_list') }}" method="get" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Search Products</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input class="form-control" type="text" placeholder="Product name" name="keywords" value="{{ request()->keywords }}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price Range</label>
                            <div class="input-group">
                                <input class="form-control" type="number" step="0.01" placeholder="Min" name="min_price" value="{{ request()->min_price }}"/>
                                <span class="input-group-text">-</span>
                                <input class="form-control" type="number" step="0.01" placeholder="Max" name="max_price" value="{{ request()->max_price }}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-funnel-fill me-1"></i> Filter
                                </button>
                                <a href="{{ route('products_list') }}" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                    
                <!-- Products List -->
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                    @forelse($products as $product)
                        <div class="col">
                            <div class="card h-100 product-card shadow-sm">
                                <div class="position-absolute top-0 end-0 p-3 price-tag">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                                
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none product-image">
                                    @if($product->photo)
                                        <img src="{{ asset('storage/products/' . $product->photo) }}" 
                                            class="card-img-top p-3" alt="{{ $product->name }}">
                                    @else
                                        <div class="no-image">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="card-body">
                                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                        <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                                    </a>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $product->model }}</h6>
                                    <p class="card-text small text-muted mb-1">Code: {{ $product->code }}</p>
                                    <p class="card-text description-text">{{ Str::limit($product->description, 100) }}</p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($product->stock_quantity > 10)
                                                <span class="badge bg-success">In Stock ({{ $product->stock_quantity }})</span>
                                            @elseif($product->stock_quantity > 0)
                                                <span class="badge bg-warning text-dark">Low Stock ({{ $product->stock_quantity }})</span>
                                            @else
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('products.show', $product) }}" class="badge bg-info text-decoration-none">
                                            <i class="bi bi-chat-text me-1"></i>{{ $product->comments->count() }}
                                        </a>
                                        <span class="badge bg-danger ms-2">
                                            <i class="bi bi-heart-fill me-1"></i>{{ $product->likes->count() }}
                                        </span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="admin-actions">
                                            @if(auth()->user() && auth()->user()->hasPermissionTo('edit_products'))
                                                <a href="{{ route('products_edit', $product) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                
                                                @if(auth()->user()->hasPermissionTo('delete_products'))
                                                    <a href="{{ route('products_delete', $product) }}" 
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="me-2">
                                            <strong>{{ $product->likes->count() }}</strong>
                                            <small class="text-muted">{{ Str::plural('like', $product->likes->count()) }}</small>
                                        </span>
                                        
                                        @auth
                                            <form action="{{ route('products.like', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn {{ $product->isLikedByUser(auth()->user()) ? 'btn-danger' : 'btn-outline-danger' }} btn-sm">
                                                    <i class="bi {{ $product->isLikedByUser(auth()->user()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-heart"></i>
                                            </a>
                                        @endauth
                                    </div>
                                    
                                    @if($product->stock_quantity < 1)
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-outline-secondary" disabled>Out of Stock</button>
                                        </div>
                                    @elseif(auth()->user() && auth()->user()->credits < $product->price)
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-outline-danger" disabled>Insufficient Credits</button>
                                        </div>
                                    @else
                                        <form action="{{ route('orders.place') }}" method="post" class="mt-3">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="input-group input-group-sm flex-grow-1">
                                                    <span class="input-group-text">Qty</span>
                                                    <input type="number" class="form-control" name="quantity" value="1" min="1"
                                                          max="{{ $product->stock_quantity }}" 
                                                          aria-label="Quantity">
                                                </div>
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bi bi-cart-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                No products found. Try adjusting your filters.
                            </div>
                        </div>
                    @endforelse
                </div>

                @if(auth()->user() && auth()->user()->hasPermissionTo('add_products'))
                <div class="mt-4 text-center">
                    <a href="{{ route('products_edit') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Add New Product
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    
    .product-image img {
        height: 200px;
        object-fit: contain;
    }
    
    .no-image {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    
    .no-image i {
        font-size: 4rem;
    }
    
    .description-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 4.5rem;
    }
    
    .price-tag {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        font-weight: bold;
        z-index: 2;
    }
    
    .admin-actions {
        display: flex;
        gap: 0.5rem;
    }
</style>
@endsection
