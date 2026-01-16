<div class="col-12">
    <div class="card" id="testimony-card">
        <div class="card-header sticky-top bg-white">
            <h4>Testimony Background</h4>
            <div class="card-header-action">
                <button class="btn btn-icon btn-primary"
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#testimony-card')"><i
                        class="fas fa-save"></i> Update
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="form-group">
                        <label class="form-control-label">Image</label>
                        config('settings.bg_testimony_url') bg_testimony
                        <x-jasni-bootstrap name="bg_testimony" :model="config('settings.bg_testimony_url')" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>