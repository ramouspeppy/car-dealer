<div class="col-12">
    <div class="card card-primary" id="card-product-category">
        <div class="card-header sticky-top bg-white">
            <h4>Product Category Form</h4>
            <div class="card-header-action">
                <button type="submit"
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#card-product-category')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ ($product_category->id) ? 'Update Product Category' : 'Create Product Category' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="category">Product Category</label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" id="category"
                            name="category" autofocus value="{{ old('category',$product_category->category) }}">
                        @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="priority">Priority</label>
                        <input type="number" class="form-control @error('priority') is-invalid @enderror" id="priority"
                            name="priority" value="{{ old('priority', $product_category->priority) }}">
                        @error('priority')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="status">Status</label>
                        <select class="form-control selectric @error('status') is-invalid @enderror" name="status">
                            <option value="active" {{ old('status', $product_category->status) == 'active' ? 'selected'
                                : ''
                                }}>Active</option>
                            <option value="non active" {{ old('status', $product_category->status) == 'non active' ?
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
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-control-label">Description</label>
                        <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc"
                            rows="2">{!! old('desc', $product_category->desc) !!}</textarea>
                        @error('desc')
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