<div class="col-12">
    <div class="card card-primary" id="card-product">
        <div class="card-header sticky-top bg-white">
            <h4>Product Type Form</h4>
            <div class="card-header-action">
                <button type="submit" onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#card-product')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ ($product_type->id) ? 'Update Product Type' : 'Create Product Type' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="product_id">Product</label>
                        <select class="form-control select2  @error('product_id') is-invalid @enderror"
                            name="product_id">
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $product->id) ==
                                $product_type->product_id ? 'selected' : ''}}>{{ $product->product }}
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="status">Status</label>
                        <select class="form-control selectric @error('status') is-invalid @enderror" name="status">
                            <option value="active" {{ old('status', $product_type->status) == 'active' ? 'selected' : ''
                                }}>Active</option>
                            <option value="non active" {{ old('status', $product_type->status) == 'non active' ?
                                'selected' : ''
                                }}>Non Active</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="type">Product Type</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                            name="type" value="{{ old('type', $product_type->type) }}" autofocus="true">
                        @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="price">Price</label>
                        <input type="text" class="form-control mask-price @error('type') is-invalid @enderror"
                            id="price" name="price" value="{{ old('price', $product_type->price) }}">
                        @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    $(function() {
        type.select();
    });
</script>
@endsection