<div class="category-form-card">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="category-form-header">

        <div class="category-form-title">

            <div class="category-form-title-icon">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>

            <div>

                <span>
                    CATEGORY MANAGEMENT
                </span>

                <h2>
                    {{ isset($category) ? 'Edit Category' : 'Create Category' }}
                </h2>

                <p>
                    {{ isset($category)
                        ? 'Update your category information and catalog settings.'
                        : 'Add a new category to organize your products.'
                    }}
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FORM BODY
    ====================================================== --}}

    <div class="category-form-body">

        <div class="category-form-grid">


            {{-- =================================================
                 CATEGORY NAME
            ================================================== --}}

            <div class="category-field category-field-half">

                <label for="category-name">

                    Category Name

                    <span>*</span>

                </label>

                <div class="category-input-wrap">

                    <i class="bi bi-grid"></i>

                    <input id="category-name" type="text" name="name" value="{{ old('name', $category->name ?? '') }}" placeholder="Enter category name" class="@error('name') is-invalid @enderror">

                </div>

                @error('name')

                <div class="category-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

                @enderror

            </div>



            {{-- =================================================
                 PARENT CATEGORY
            ================================================== --}}

            <div class="category-field category-field-half">

                <label for="parent_id">
                    Parent Category
                </label>

                <div class="category-select-wrap">

                    <i class="bi bi-diagram-3"></i>

                    <select id="parent_id" name="parent_id" class="category-select @error('parent_id') is-invalid @enderror">

                        <option value="">
                            Main Category
                        </option>

                        @foreach($parents as $parent)

                        <option value="{{ $parent->id }}" @selected( old( 'parent_id' , $category->parent_id ?? ''
                            ) == $parent->id
                            )
                            >
                            {{ $parent->name }}
                        </option>

                        @endforeach

                    </select>

                </div>

                @error('parent_id')

                <div class="category-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

                @enderror

            </div>



            {{-- =================================================
                 DESCRIPTION
            ================================================== --}}

            <div class="category-field category-field-full">

                <label for="category-description">
                    Description
                </label>

                <div class="category-textarea-wrap">

                    <i class="bi bi-text-paragraph"></i>

                    <textarea id="category-description" name="description" rows="5" placeholder="Write a short description about this category..." class="@error('description') is-invalid @enderror">{{ old('description', $category->description ?? '') }}</textarea>

                </div>

                @error('description')

                <div class="category-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

                @enderror

            </div>



            {{-- =================================================
                 IMAGE
            ================================================== --}}

            <div class="category-field category-field-full">

                <label for="category-image">
                    Category Image
                </label>

                <div class="category-upload-area">

                    <input id="category-image" type="file" name="image" accept="image/*" class="category-file-input @error('image') is-invalid @enderror">

                    <label for="category-image" class="category-upload-content">

                        <div class="category-upload-icon">

                            <i class="bi bi-cloud-arrow-up"></i>

                        </div>

                        <div>

                            <strong>
                                Upload Category Image
                            </strong>

                            <span>
                                Click to browse or drag & drop your image here
                            </span>

                            <small>
                                PNG, JPG, JPEG, WEBP
                            </small>

                        </div>

                    </label>

                </div>


                {{-- Existing Image --}}

                @if (!empty($category?->image))

                <div class="category-current-image">

                    <div class="category-current-image-preview">

                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}">

                    </div>

                    <div class="category-current-image-info">

                        <span>
                            CURRENT IMAGE
                        </span>

                        <strong>
                            {{ $category->name }}
                        </strong>

                        <small>
                            Upload a new image to replace it.
                        </small>

                    </div>

                </div>

                @endif


                @error('image')

                <div class="category-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

                @enderror

            </div>



            {{-- =================================================
                 STATUS
            ================================================== --}}

            <div class="category-field category-field-half">

                <label for="category-status">
                    Status
                </label>

                <div class="category-select-wrap">

                    <i class="bi bi-activity"></i>

                    <select id="category-status" name="status" class="category-select @error('status') is-invalid @enderror">

                        <option value="1" @selected( (string) old( 'status' , (int) ($category->status ?? true)
                            ) === '1'
                            )
                            >
                            Active
                        </option>

                        <option value="0" @selected( (string) old( 'status' , (int) ($category->status ?? true)
                            ) === '0'
                            )
                            >
                            Inactive
                        </option>

                    </select>

                </div>

                @error('status')

                <div class="category-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

                @enderror

            </div>



            {{-- =================================================
                 SORT ORDER
            ================================================== --}}

            <div class="category-field category-field-half">

                <label for="category-sort-order">
                    Sort Order
                </label>

                <div class="category-input-wrap">

                    <i class="bi bi-sort-numeric-down"></i>

                    <input id="category-sort-order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" placeholder="0" class="@error('sort_order') is-invalid @enderror">

                </div>

                @error('sort_order')

                <div class="category-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

                @enderror

            </div>

        </div>

    </div>



    {{-- =====================================================
         FOOTER ACTIONS
    ====================================================== --}}

    <div class="category-form-footer">

        <a href="{{ route('admin.categories.index') }}" class="category-form-cancel">

            <i class="bi bi-arrow-left"></i>

            Cancel

        </a>


        <button type="submit" class="category-form-submit">

            <i class="bi bi-check2-circle"></i>

            {{ isset($category) ? 'Update Category' : 'Save Category' }}

        </button>

    </div>

</div>
