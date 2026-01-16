<div class="col-12">
    <div class="card card-primary" id="photo-delivery-card">
        <div class="card-header sticky-top bg-white">
            <h4>Photo Delivery Form</h4>
            <div class="card-header-action">
                <button type="submit"
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#photo-delivery-card')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ $delivery->id ? 'Update Photo Delivery' : 'Create Photo Delivery' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label" for="product_id">Product</label>
                        <select class="form-control select2  @error('product_id') is-invalid @enderror"
                            name="product_id">
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $product->id) ==
                                $delivery->product_id ? 'selected' : ''}}>{{ $product->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('product_id')
                        <div class="text-danger">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label">Photo Delivery</label>
                        <x-dropzone name="images" :existing-files="$delivery->images" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>