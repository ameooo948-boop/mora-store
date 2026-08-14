<div class="brand-form-card">

    {{-- =====================================================
         FORM HEADER
    ====================================================== --}}

    <div class="brand-form-header">

        <div class="brand-form-title">

            <div class="brand-form-title-icon">
                <i class="bi bi-tags-fill"></i>
            </div>

            <div>

                <span>
                    BRAND INFORMATION
                </span>

                <h2>
                    {{ isset($brand) ? 'Edit Brand' : 'Create Brand' }}
                </h2>

                <p>
                    {{ isset($brand)
                        ? 'Update your brand information and settings.'
                        : 'Add a new brand to your product catalog.'
                    }}
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FORM BODY
    ====================================================== --}}

    <div class="brand-form-body">

        <div class="brand-form-grid">


            {{-- =================================================
                 BRAND NAME
            ================================================== --}}

            <div class="brand-field brand-field-half">

                <label for="brand-name">

                    Brand Name

                    <span>*</span>

                </label>

                <div class="brand-input-wrap">

                    <i class="bi bi-tag"></i>

                    <input id="brand-name" type="text" name="name" value="{{ old('name', $brand->name ?? '') }}" placeholder="Enter brand name" class="@error('name') is-invalid @enderror">

                </div>

                @error('name')

                <div class="brand-error">
                    <i class="bi bi-exclamation-circle"></i>
                    {{ $message }}
                </div>

                @enderror

            </div>



            {{-- =================================================
                 STATUS
            ================================================== --}}

            <div class="brand-field brand-field-quarter">

                <label for="brand-status">
                    Status
                </label>

                <select id="brand-status" name="status" class="brand-select @error('status') is-invalid @enderror">

                    <option value="1" @selected( (string) old( 'status' , (int) ($brand->status ?? true)
                        ) === '1'
                        )
                        >
                        Active
                    </option>

                    <option value="0" @selected( (string) old( 'status' , (int) ($brand->status ?? true)
                        ) === '0'
                        )
                        >
                        Inactive
                    </option>

                </select>

                @error('status')

                <div class="brand-error">
                    <i class="bi bi-exclamation-circle"></i>
                    {{ $message }}
                </div>

                @enderror

            </div>



            {{-- =================================================
                 SORT ORDER
            ================================================== --}}

            <div class="brand-field brand-field-quarter">

                <label for="brand-sort-order">
                    Sort Order
                </label>

                <div class="brand-input-wrap">

                    <i class="bi bi-sort-numeric-down"></i>

                    <input id="brand-sort-order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $brand->sort_order ?? 0) }}" placeholder="0" class="@error('sort_order') is-invalid @enderror">

                </div>

                @error('sort_order')

                <div class="brand-error">
                    <i class="bi bi-exclamation-circle"></i>
                    {{ $message }}
                </div>

                @enderror

            </div>



            {{-- =================================================
                 DESCRIPTION
            ================================================== --}}

            <div class="brand-field brand-field-full">

                <label for="brand-description">
                    Description
                </label>

                <div class="brand-textarea-wrap">

                    <i class="bi bi-text-paragraph"></i>

                    <textarea id="brand-description" name="description" rows="5" placeholder="Write a short description about this brand..." class="@error('description') is-invalid @enderror">{{ old('description', $brand->description ?? '') }}</textarea>

                </div>

                @error('description')

                <div class="brand-error">
                    <i class="bi bi-exclamation-circle"></i>
                    {{ $message }}
                </div>

                @enderror

            </div>



            {{-- =================================================
                 LOGO UPLOAD
            ================================================== --}}

            <div class="brand-field brand-field-full">

                <label for="brand-logo">
                    Brand Logo
                </label>

                <div class="brand-upload-area">

                    <input id="brand-logo" type="file" name="logo" accept="image/*" class="brand-file-input @error('logo') is-invalid @enderror">


                    <label for="brand-logo" class="brand-upload-content">

                        <div class="brand-upload-icon">

                            <i class="bi bi-cloud-arrow-up"></i>

                        </div>

                        <div>

                            <strong>
                                Upload Brand Logo
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


                {{-- Existing Logo --}}

                @if (!empty($brand?->logo))

                <div class="brand-current-logo">

                    <div class="brand-current-logo-preview">

                        <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}">

                    </div>

                    <div class="brand-current-logo-info">

                        <span>
                            CURRENT LOGO
                        </span>

                        <strong>
                            {{ $brand->name }}
                        </strong>

                        <small>
                            Upload a new image to replace it.
                        </small>

                    </div>

                </div>

                @endif


                @error('logo')

                <div class="brand-error">
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

    <div class="brand-form-footer">

        <a href="{{ route('admin.brands.index') }}" class="brand-form-cancel">

            <i class="bi bi-arrow-left"></i>

            Cancel

        </a>


        <button type="submit" class="brand-form-submit">

            <i class="bi bi-check2-circle"></i>

            {{ isset($brand) ? 'Update Brand' : 'Save Brand' }}

        </button>

    </div>

</div>
