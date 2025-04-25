@extends('layouts.master')
@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Product Details -->
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-4 mb-md-0">
                            @if($product->photo)
                                <img src="{{ asset('storage/products/' . $product->photo) }}" 
                                     class="img-fluid rounded" alt="{{ $product->name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px">
                                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <h1 class="h2 mb-2">{{ $product->name }}</h1>
                            <p class="text-muted mb-3">Model: {{ $product->model }} | Code: {{ $product->code }}</p>
                            <h3 class="text-primary mb-3">${{ number_format($product->price, 2) }}</h3>
                            
                            <div class="mb-4">
                                @if($product->stock_quantity > 10)
                                    <span class="badge bg-success">In Stock ({{ $product->stock_quantity }})</span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="badge bg-warning text-dark">Low Stock ({{ $product->stock_quantity }})</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </div>
                            
                            <div class="mb-4">
                                <h5>Description</h5>
                                <p>{{ $product->description }}</p>
                            </div>
                            
                            @if($product->stock_quantity > 0)
                                <form action="{{ route('orders.place') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="d-flex">
                                        <div class="input-group me-3" style="width: 130px;">
                                            <span class="input-group-text">Qty</span>
                                            <input type="number" name="quantity" value="1" min="1" 
                                                   max="{{ $product->stock_quantity }}" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Comments Section -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4>Customer Reviews</h4>
                </div>
                <div class="card-body">
                    <!-- Comments List -->
                    @if($product->comments->count() > 0)
                        <div class="mb-4">
                            @foreach($product->comments as $comment)
                                <div class="border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong>{{ $comment->user->name }}</strong>
                                            <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if(auth()->id() == $comment->user_id || auth()->user()->hasPermissionTo('delete_comments'))
                                            <form action="{{ route('product.comments.destroy', $comment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this comment?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    @if($comment->rating)
                                        <div class="mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $comment->rating)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    @endif
                                    <p class="mb-0">{{ $comment->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                    @endif
                    
                    <!-- Add Comment Form -->
                    @auth
                        <div class="mt-4">
                            <h5>Write a Review</h5>
                            <form action="{{ route('product.comments.store', $product) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Rating (optional)</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating1" value="1">
                                            <label class="form-check-label" for="rating1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating2" value="2">
                                            <label class="form-check-label" for="rating2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating3" value="3">
                                            <label class="form-check-label" for="rating3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating4" value="4">
                                            <label class="form-check-label" for="rating4">4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating5" value="5">
                                            <label class="form-check-label" for="rating5">5</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Your Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-chat-left-text me-1"></i> Submit Review
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Please <a href="{{ route('login') }}">login</a> to leave a review.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Similar Products</h5>
                </div>
                <div class="card-body">
                    <!-- You can implement similar products logic here -->
                    <p class="text-muted">Feature coming soon...</p>
                </div>
            </div>
            
            <div class="d-grid">
                <a href="{{ route('products_list') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Products
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
