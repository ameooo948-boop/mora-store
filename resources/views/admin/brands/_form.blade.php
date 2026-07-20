<div class="card shadow-sm border-0">

    <div class="card-body p-4">

        <div class="row">

            {{-- Brand Name --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Brand Name <span class="text-danger">*</span>
                </label>

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Brand name" value="{{ old('name', $brand->name ?? '') }}">

                @error('name')
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

                <textarea rows="5" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Write Brand description...">{{ old('description', $brand->description ?? '') }}</textarea>

                @error('description')
                <div class="invalid-feedback">

                    {{ $message }}

                </div>
                @enderror

            </div>

            {{-- logo --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">

                    Brand logo

                </label>

                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">

                @if (!empty($brand?->logo))
                <div class="mt-2">
                    <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}" class="img-thumbnail" width="120">
                </div>
                @endif

                @error('logo')
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

                    <option value="1" @selected((string) old('status', (int) ($brand->status ?? true)) === '1')
                        >
                        Active
                    </option>

                    <option value="0" @selected((string) old('status', (int) ($brand->status ?? true)) === '0')
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

            {{-- Sort Order --}}
            <div class="col-md-3 mb-3">

                <label class="form-label fw-semibold">

                    Sort Order

                </label>

                <input type="number" min="0" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $brand->sort_order ?? 0) }}">

                @error('sort_order')
                <div class="invalid-feedback">

                    {{ $message }}

                </div>
                @enderror

            </div>

        </div>

    </div>

    <div class="card-footer bg-white d-flex justify-content-end">

        <a href="{{ route('admin.brands.index') }}" class="btn btn-light me-2">
            Cancel
        </a>

        <button type="submit" class="btn btn-primary">

            <i class="bi bi-check-lg"></i>

            Save Brand

        </button>

    </div>

</div>
