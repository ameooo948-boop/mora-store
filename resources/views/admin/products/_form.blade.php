<div class="product-form-card">


    {{-- =====================================================
         BASIC INFORMATION
    ====================================================== --}}

    <div class="product-form-section">

        <div class="product-form-section-header">

            <div class="product-form-section-icon blue">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <h3>
                    Basic Information
                </h3>

                <span>
                    Product identity and catalog classification
                </span>

            </div>

        </div>


        <div class="product-form-grid">


            {{-- Product Name --}}

            <div class="product-form-field field-wide">

                <label>
                    Product Name
                    <span>*</span>
                </label>

                <div class="product-form-input">

                    <i class="bi bi-tag"></i>

                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" placeholder="Enter product name" class="@error('name') is-invalid @enderror">

                </div>

                @error('name')
                <div class="product-form-error">
                    {{ $message }}
                </div>
                @enderror

            </div>


            {{-- Category --}}

            <div class="product-form-field">

                <label>
                    Category
                    <span>*</span>
                </label>

                <div class="product-form-input">

                    <i class="bi bi-grid"></i>

                    <select name="category_id" class="@error('category_id') is-invalid @enderror">

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                        <option value="{{ $category->id }}" @selected( old( 'category_id' , $product->category_id ?? ''
                            ) == $category->id
                            )
                            >
                            {{ $category->name }}
                        </option>

                        @endforeach

                    </select>

                </div>

                @error('category_id')
                <div class="product-form-error">
                    {{ $message }}
                </div>
                @enderror

            </div>


            {{-- Brand --}}

            <div class="product-form-field">

                <label>
                    Brand
                    <span>*</span>
                </label>

                <div class="product-form-input">

                    <i class="bi bi-tags"></i>

                    <select name="brand_id" class="@error('brand_id') is-invalid @enderror">

                        <option value="">
                            Select Brand
                        </option>

                        @foreach($brands as $brand)

                        <option value="{{ $brand->id }}" @selected( old( 'brand_id' , $product->brand_id ?? ''
                            ) == $brand->id
                            )
                            >
                            {{ $brand->name }}
                        </option>

                        @endforeach

                    </select>

                </div>

                @error('brand_id')
                <div class="product-form-error">
                    {{ $message }}
                </div>
                @enderror

            </div>


            {{-- Description --}}

            <div class="product-form-field field-full">

                <label>
                    Description
                </label>

                <div class="product-form-textarea">

                    <i class="bi bi-text-paragraph"></i>

                    <textarea name="description" rows="5" placeholder="Write a detailed product description..." class="@error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>

                </div>

                @error('description')
                <div class="product-form-error">
                    {{ $message }}
                </div>
                @enderror

            </div>

        </div>

    </div>



    {{-- =====================================================
         PRICING & INVENTORY
    ====================================================== --}}

    <div class="product-form-section">

        <div class="product-form-section-header">

            <div class="product-form-section-icon green">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div>

                <h3>
                    Pricing & Inventory
                </h3>

                <span>
                    Manage pricing, stock and product ordering
                </span>

            </div>

        </div>


        <div class="product-form-grid pricing-grid">


            {{-- Price --}}

            <div class="product-form-field">

                <label>
                    Price
                    <span>*</span>
                </label>

                <div class="product-form-input">

                    <i class="bi bi-currency-dollar"></i>

                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '') }}" placeholder="0.00" class="@error('price') is-invalid @enderror">

                </div>

                @error('price')
                <div class="product-form-error">
                    {{ $message }}
                </div>
                @enderror

            </div>


            {{-- Sale Price --}}

            <div class="product-form-field">

                <label>
                    Sale Price
                </label>

                <div class="product-form-input sale-input">

                    <i class="bi bi-percent"></i>

                    <input type="number" step="0.01" min="0" name="sale_price" value="{{ old('sale_price', $product->sale_price ?? '') }}" placeholder="Optional" class="@error('sale_price') is-invalid @enderror">

                </div>

                @error('sale_price')
                <div class="product-form-error">
                    {{ $message }}
                </div>
                @enderror

            </div>


            {{-- Quantity --}}

            <div class="product-form-field">

                <label>
                    Quantity
                </label>

                <div class="product-form-input">

                    <i class="bi bi-box-seam"></i>

                    <input type="number" min="0" name="quantity" value="{{ old('quantity', $product->quantity ?? 0) }}" placeholder="0" class="@error('quantity') is-invalid @enderror">

                </div>

                @error('quantity')
                <div class="product-form-error">
                    {{ $message }}
                </div>
                @enderror

            </div>


            {{-- Sort Order --}}

            <div class="product-form-field">

                <label>
                    Sort Order
                </label>

                <div class="product-form-input">

                    <i class="bi bi-sort-numeric-down"></i>

                    <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" placeholder="0" class="@error('sort_order') is-invalid @enderror">

                </div>

                @error('sort_order')
                <div class="product-form-error">
                    {{ $message }}
                </div>
                @enderror

            </div>

        </div>

    </div>



    {{-- =====================================================
         PRODUCT SETTINGS
    ====================================================== --}}

    <div class="product-form-section">

        <div class="product-form-section-header">

            <div class="product-form-section-icon purple">
                <i class="bi bi-sliders"></i>
            </div>

            <div>

                <h3>
                    Product Settings
                </h3>

                <span>
                    Configure product visibility and storefront behavior
                </span>

            </div>

        </div>


        <div class="product-settings-grid">


            {{-- Featured --}}

            <div class="product-setting-card">

                <div class="product-setting-icon yellow">
                    <i class="bi bi-star-fill"></i>
                </div>

                <div class="product-setting-content">

                    <strong>
                        Featured Product
                    </strong>

                    <span>
                        Display this product in featured sections
                    </span>

                </div>

                <select name="featured" class="@error('featured') is-invalid @enderror">

                    <option value="1" @selected( (string) old( 'featured' , (int) ($product->featured ?? false)
                        ) === '1'
                        )
                        >
                        Yes
                    </option>

                    <option value="0" @selected( (string) old( 'featured' , (int) ($product->featured ?? false)
                        ) === '0'
                        )
                        >
                        No
                    </option>

                </select>

            </div>


            {{-- Status --}}

            <div class="product-setting-card">

                <div class="product-setting-icon green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div class="product-setting-content">

                    <strong>
                        Product Status
                    </strong>

                    <span>
                        Control product visibility in the store
                    </span>

                </div>

                <select name="status" class="@error('status') is-invalid @enderror">

                    <option value="1" @selected( (string) old( 'status' , (int) ($product->status ?? true)
                        ) === '1'
                        )
                        >
                        Active
                    </option>

                    <option value="0" @selected( (string) old( 'status' , (int) ($product->status ?? true)
                        ) === '0'
                        )
                        >
                        Inactive
                    </option>

                </select>

            </div>

        </div>


        @error('featured')
        <div class="product-form-error mt-2">
            {{ $message }}
        </div>
        @enderror

        @error('status')
        <div class="product-form-error mt-2">
            {{ $message }}
        </div>
        @enderror

    </div>



    {{-- =====================================================
         PRODUCT IMAGES
    ====================================================== --}}

    <div class="product-form-section">

        <div class="product-form-section-header">

            <div class="product-form-section-icon orange">
                <i class="bi bi-images"></i>
            </div>

            <div>

                <h3>
                    Product Images
                </h3>

                <span>
                    Upload and manage product gallery images
                </span>

            </div>

        </div>


        {{-- Upload --}}

        <label class="product-upload-area">

            <input type="file" name="images[]" multiple hidden id="product-images-input">

            <div class="product-upload-icon">
                <i class="bi bi-cloud-arrow-up-fill"></i>
            </div>

            <strong>
                Upload Product Images
            </strong>

            <span>
                Click to browse or select multiple images
            </span>

            <small>
                JPG, JPEG, PNG, WEBP
            </small>

        </label>


        @error('images')
        <div class="product-form-error mt-2">
            {{ $message }}
        </div>
        @enderror

        @error('images.*')
        <div class="product-form-error mt-2">
            {{ $message }}
        </div>
        @enderror



        {{-- Existing Images --}}

        @isset($product)

        @if($product->images->count())

        <div class="product-existing-images">

            <div class="product-existing-header">

                <div>

                    <strong>
                        Current Images
                    </strong>

                    <span>
                        {{ $product->images->count() }}
                        {{ Str::plural('image', $product->images->count()) }}
                    </span>

                </div>

            </div>


            <div class="product-image-gallery">

                @foreach($product->images as $image)

                <div class="product-existing-image">

                    <img src="{{ $image->image_url }}" alt="{{ $product->name }}">

                    <button type="button" class="product-image-delete delete-image-btn" data-url="{{ route('admin.product-images.destroy', $image) }}" title="Delete Image">

                        <i class="bi bi-trash3"></i>

                    </button>

                </div>

                @endforeach

            </div>

        </div>

        @endif

        @endisset

    </div>



    {{-- =====================================================
         FOOTER ACTIONS
    ====================================================== --}}

    <div class="product-form-footer">

        <a href="{{ route('admin.products.index') }}" class="product-form-cancel">

            <i class="bi bi-x-lg"></i>

            Cancel

        </a>


        <button type="submit" class="product-form-submit">

            <i class="bi bi-check-lg"></i>

            {{ isset($product) ? 'Update Product' : 'Create Product' }}

        </button>

    </div>

</div>
