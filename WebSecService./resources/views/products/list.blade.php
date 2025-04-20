@extends('layouts.master')
@section('title', 'Products')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
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
                    <div class="col-md-3">
                        <label class="form-label">Price Range</label>
                        <div class="input-group">
                            <input class="form-control" type="number" step="0.01" placeholder="Min" name="min_price" value="{{ request()->min_price }}"/>
                            <span class="input-group-text">-</span>
                            <input class="form-control" type="number" step="0.01" placeholder="Max" name="max_price" value="{{ request()->max_price }}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('products_list') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Product Grid -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($products as $product)
                    <div class="col">
                        <div class="card h-100 product-card shadow-sm">
                            <div class="badge bg-primary position-absolute top-0 end-0 m-2">
                                ${{ number_format($product->price, 2) }}
                            </div>
                            
                            @if($product->photo)
                                <img src="{{ asset('storage/products/' . $product->photo) }}" 
                                     class="card-img-top p-3" alt="{{ $product->name }}"
                                     style="height: 200px; object-fit: contain;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light p-3" 
                                     style="height: 200px;">
                                    <i class="bi bi-box-seam text-secondary" style="font-size: 5rem;"></i>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $product->model }}</h6>
                                <p class="card-text small text-muted mb-1">Code: {{ $product->code }}</p>
                                <p class="card-text description-text">{{ Str::limit($product->description, 100) }}</p>
                                
                                @if(auth()->check())
                                    @if(auth()->user()->hasRole('Customer'))
                                        <div class="stock-badge mb-2">
                                            @if($product->stock_quantity > 10)
                                                <span class="badge bg-success">In Stock ({{ $product->stock_quantity }})</span>
                                            @elseif($product->stock_quantity > 0)
                                                <span class="badge bg-warning text-dark">Low Stock ({{ $product->stock_quantity }})</span>
                                            @else
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                @if(auth()->check())
                                    @if(auth()->user()->hasAnyRole(['Admin', 'Employee']))
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Stock: {{ $product->stock_quantity }}</span>
                                            <div>
                                                <a href="{{ route('products_edit', $product) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                {{-- <a href="{{ route('products_reset', $product) }}" 
                                                   class="btn btn-sm btn-warning"
                                                   onclick="return confirm('Are you sure you want to reset the stock to 0?')">
                                                    <i class="bi bi-arrow-repeat"></i> Reset
                                                </a> --}}
                                                @if(auth()->user()->hasPermissionTo('delete_products'))
                                                    <a href="{{ route('products_delete', $product) }}" 
                                                       class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @elseif(auth()->user()->hasRole('Customer'))
                                        @if($product->stock_quantity < 1)
                                            <button class="btn btn-secondary w-100" disabled>
                                                <i class="bi bi-x-circle me-1"></i> Out of Stock
                                            </button>
                                        @elseif(auth()->user()->credits < $product->price)
                                            <button class="btn btn-warning w-100" disabled>
                                                <i class="bi bi-cash-stack me-1"></i> Insufficient Credits
                                            </button>
                                        @else
                                            <form action="{{ route('orders.place') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="d-flex">
                                                    <div class="input-group flex-nowrap me-2">
                                                        <span class="input-group-text">Qty</span>
                                                        <input type="number" name="quantity" value="1" min="1" 
                                                               max="{{ $product->stock_quantity }}" 
                                                               class="form-control form-control-sm" style="width: 60px">
                                                    </div>
                                                    <button type="submit" class="btn btn-success flex-grow-1">
                                                        <i class="bi bi-cart-plus me-1"></i> Buy Now
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No products found. Try adjusting your filters.
                        </div>
                    </div>
                @endforelse
            </div>

            @if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Employee']))
                <div class="mt-4">
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
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid rgba(0,0,0,0.1);
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .description-text {
        height: 3em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .stock-badge {
        position: absolute;
        top: 0;
        left: 0;
        margin: 0.5rem;
    }
</style>
@endsection
