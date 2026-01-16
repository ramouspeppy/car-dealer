<div class="col-12">
    <div class="card" id="header-card">
        <div class="card-header sticky-top bg-white">
            <h4>Header Form</h4>
            <div class="card-header-action">
                <button class="btn btn-icon btn-primary"
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#header-card')"><i
                        class="fas fa-save"></i> Update
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="form-group">
                        <label class="form-control-label">Image</label>
                        <x-jasni-bootstrap name="bg_header_other" :model="config('settings.bg_header_other')" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>