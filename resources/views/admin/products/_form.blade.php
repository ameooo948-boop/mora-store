<div class="card shadow-sm border-0">

    <div class="card-body p-4">

        <div class="row">

            {{-- Product Name --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Product Name <span class="text-danger">*</span>
                </label>

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter product name" value="{{ old('name', $product->name ?? '') }}">

                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Category --}}
            <div class="col-md-3 mb-3">

                <label class="form-label fw-semibold">
                    Category <span class="text-danger">*</span>
                </label>

                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">

                    <option value="">Select Category</option>

                    @foreach($categories as $category)

                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)
                        >
                        {{ $category->name }}
                    </option>

                    @endforeach

                </select>

                @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Brand --}}
            <div class="col-md-3 mb-3">

                <label class="form-label fw-semibold">
                    Brand <span class="text-danger">*</span>
                </label>

                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">

                    <option value="">Select Brand</option>

                    @foreach($brands as $brand)

                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id ?? '') == $brand->id)
                        >
                        {{ $brand->name }}
                    </option>

                    @endforeach

                </select>

                @error('brand_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Description --}}
            <div class="col-12 mb-3">

                <label class="form-label fw-semibold">
                    Description
                </label>

                <textarea rows="5" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Write product description...">{{ old('description', $product->description ?? '') }}</textarea>

                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Price --}}
            <div class="col-md-3 mb-3">

                <label class="form-label fw-semibold">
                    Price <span class="text-danger">*</span>
                </label>

                <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price ?? '') }}">

                @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Sale Price --}}
            <div class="col-md-3 mb-3">

                <label class="form-label fw-semibold">
                    Sale Price
                </label>

                <input type="number" step="0.01" min="0" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', $product->sale_price ?? '') }}">

                @error('sale_price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Quantity --}}
            <div class="col-md-2 mb-3">

                <label class="form-label fw-semibold">
                    Quantity
                </label>

                <input type="number" min="0" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity ?? 0) }}">

                @error('quantity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Sort Order --}}
            <div class="col-md-2 mb-3">

                <label class="form-label fw-semibold">
                    Sort Order
                </label>

                <input type="number" min="0" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $product->sort_order ?? 0) }}">

                @error('sort_order')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Featured --}}
            <div class="col-md-2 mb-3">

                <label class="form-label fw-semibold">
                    Featured
                </label>

                <select name="featured" class="form-select @error('featured') is-invalid @enderror">

                    <option value="1" @selected((string) old('featured', (int) ($product->featured ?? false)) === '1')
                        >
                        Yes
                    </option>

                    <option value="0" @selected((string) old('featured', (int) ($product->featured ?? false)) === '0')
                        >
                        No
                    </option>

                </select>

                @error('featured')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Status --}}
            <div class="col-md-3 mb-3">

                <label class="form-label fw-semibold">
                    Status
                </label>

                <select name="status" class="form-select @error('status') is-invalid @enderror">

                    <option value="1" @selected((string) old('status', (int) ($product->status ?? true)) === '1')
                        >
                        Active
                    </option>

                    <option value="0" @selected((string) old('status', (int) ($product->status ?? true)) === '0')
                        >
                        Inactive
                    </option>

                </select>

                @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Images --}}
            <div class="col-12 mb-3">

                <label class="form-label fw-semibold">
                    Product Images
                </label>

                <input type="file" name="images[]" multiple class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror">

                @error('images')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

                @error('images.*')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Existing Images --}}
            @isset($product)

            @if($product->images->count())

            <div class="col-12">

                <label class="form-label fw-semibold">
                    Current Images
                </label>

                <div class="d-flex flex-wrap gap-3">

                    @foreach($product->images as $image)

                    <div class="position-relative">

                        <img src="{{ $image->image_url }}" class="rounded border" width="120" height="120" style="object-fit: cover;">

                        {{-- Delete button later --}}

                        <button type="button" class="btn btn-sm btn-danger delete-image-btn" data-url="{{ route('admin.product-images.destroy', $image) }}">
                            <i class="bi bi-trash"></i>
                        </button>

                    </div>

                    @endforeach

                </div>

            </div>

            @endif

            @endisset

        </div>

    </div>

    <div class="card-footer bg-white d-flex justify-content-end">

        <a href="{{ route('admin.products.index') }}" class="btn btn-light me-2">
            Cancel
        </a>

        <button type="submit" class="btn btn-primary">

            <i class="bi bi-check-lg"></i>

            {{ isset($product) ? 'Update Product' : 'Create Product' }}

        </button>

    </div>

</div>
