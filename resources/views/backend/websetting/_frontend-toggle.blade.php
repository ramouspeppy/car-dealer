<button type="button" class="btn btn-sm btn-icon btn-outline-primary frontend-visibility-trigger" data-toggle="modal" data-target="#frontendVisibilityModal" data-tooltip="Setting" aria-label="Pengaturan tayangan">
    <i class="fas fa-cog" aria-hidden="true"></i>
</button>

<div class="modal fade frontend-visibility-modal" id="frontendVisibilityModal" tabindex="-1" role="dialog" aria-labelledby="frontendVisibilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="frontend-visibility-heading">
                    <span class="frontend-visibility-heading-icon"><i class="fas fa-sliders-h" aria-hidden="true"></i></span>
                    <div>
                        <h5 class="modal-title" id="frontendVisibilityModalLabel">Pengaturan Tayangan</h5>
                        <p class="mb-0">Atur halaman dan bagian yang tampil di website.</p>
                    </div>
                </div>
                <button type="button" class="close frontend-visibility-close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="frontend-visibility-options">
                    @foreach ($toggles as $toggle)
                        @php
                            $settingKey = $toggle['key'];
                            $isActive = filter_var(config("settings.{$settingKey}", '1'), FILTER_VALIDATE_BOOLEAN);
                            $toggleIsActive = filter_var(old($settingKey, $isActive ? '1' : '0'), FILTER_VALIDATE_BOOLEAN);
                        @endphp
                        <div class="frontend-visibility-row">
                            <div class="frontend-visibility-copy">
                                <span class="frontend-visibility-option-icon"><i class="fas fa-eye" aria-hidden="true"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ $toggle['label'] }}</h6>
                                    <span class="text-muted frontend-visibility-status">{{ $toggleIsActive ? 'Tayangan aktif' : 'Tayangan nonaktif' }}</span>
                                </div>
                            </div>
                            <label class="custom-switch mb-0">
                                <input
                                    type="checkbox"
                                    class="custom-switch-input frontend-visibility-toggle"
                                    data-setting-key="{{ $settingKey }}"
                                    data-url="{{ route('backend.setting.toggle') }}"
                                    aria-label="{{ $toggle['label'] }}"
                                    {{ $toggleIsActive ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description frontend-visibility-label">{{ $toggleIsActive ? 'Aktif' : 'Nonaktif' }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <span><i class="fas fa-bolt mr-1" aria-hidden="true"></i>Perubahan tersimpan otomatis</span>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Selesai</button>
            </div>
        </div>
    </div>
</div>

<style>
    .frontend-visibility-trigger {
        position: relative;
        margin-left: 12px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(103, 119, 239, .12);
    }

    .frontend-visibility-trigger::after {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        z-index: 1080;
        padding: 5px 9px;
        border-radius: 6px;
        background: #34395e;
        color: #fff;
        content: attr(data-tooltip);
        font-size: 11px;
        font-weight: 500;
        line-height: 1.4;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-3px);
        transition: opacity .15s ease, transform .15s ease, visibility .15s ease;
        pointer-events: none;
    }

    .frontend-visibility-trigger:hover::after,
    .frontend-visibility-trigger:focus::after {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .frontend-visibility-trigger:hover,
    .frontend-visibility-trigger:focus {
        box-shadow: 0 5px 14px rgba(103, 119, 239, .24);
        transform: translateY(-1px);
    }

    .frontend-visibility-modal .modal-dialog {
        max-width: 560px;
    }

    .frontend-visibility-modal .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 18px;
        box-shadow: 0 24px 70px rgba(31, 41, 80, .24);
    }

    .frontend-visibility-modal .modal-header {
        padding: 24px 26px;
        border: 0;
        background: linear-gradient(120deg, #5367e8 0%, #7888f5 100%);
        color: #fff;
    }

    .frontend-visibility-heading {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .frontend-visibility-heading-icon {
        display: inline-flex;
        width: 46px;
        height: 46px;
        align-items: center;
        justify-content: center;
        flex: 0 0 46px;
        border: 1px solid rgba(255, 255, 255, .3);
        border-radius: 14px;
        background: rgba(255, 255, 255, .16);
        font-size: 18px;
    }

    .frontend-visibility-modal .modal-title {
        color: #fff;
        font-size: 17px;
        font-weight: 700;
    }

    .frontend-visibility-heading p {
        margin-top: 4px;
        color: rgba(255, 255, 255, .82);
        font-size: 12px;
    }

    .frontend-visibility-close {
        color: #fff !important;
        opacity: .8;
        text-shadow: none;
    }

    .frontend-visibility-close:hover {
        opacity: 1;
    }

    .frontend-visibility-modal .modal-body {
        padding: 20px 24px 10px;
        background: #f7f8fc;
    }

    .frontend-visibility-options {
        display: grid;
        gap: 11px;
    }

    .frontend-visibility-modal .frontend-visibility-row {
        display: flex;
        min-height: 76px;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 16px;
        border: 1px solid #e9ebf4;
        border-radius: 13px;
        background: #fff;
        box-shadow: 0 3px 10px rgba(39, 52, 100, .035);
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .frontend-visibility-modal .frontend-visibility-row:hover {
        transform: translateY(-1px);
        border-color: #d7dcff;
        box-shadow: 0 7px 18px rgba(39, 52, 100, .08);
    }

    .frontend-visibility-modal .frontend-visibility-copy {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .frontend-visibility-modal .frontend-visibility-option-icon {
        display: inline-flex;
        width: 38px;
        height: 38px;
        align-items: center;
        justify-content: center;
        flex: 0 0 38px;
        border-radius: 11px;
        background: #eef0ff;
        color: #6275eb;
    }

    .frontend-visibility-modal .frontend-visibility-copy h6 {
        color: #34395e;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.4;
    }

    .frontend-visibility-modal .frontend-visibility-copy .frontend-visibility-status {
        font-size: 11px;
    }

    .frontend-visibility-modal .custom-switch {
        flex: 0 0 auto;
    }

    .frontend-visibility-modal .modal-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 24px 20px;
        border: 0;
        background: #f7f8fc;
    }

    .frontend-visibility-modal .modal-footer > span {
        color: #8991a8;
        font-size: 11px;
    }

    .frontend-visibility-modal .modal-footer .btn {
        min-width: 100px;
        border-radius: 8px;
    }

    @media (max-width: 575.98px) {
        .frontend-visibility-modal .modal-dialog {
            margin: 12px;
        }

        .frontend-visibility-modal .modal-header {
            padding: 19px;
        }

        .frontend-visibility-modal .modal-body {
            padding: 16px 14px 8px;
        }

        .frontend-visibility-modal .modal-footer {
            padding: 12px 14px 16px;
        }

        .frontend-visibility-modal .frontend-visibility-row {
            padding: 12px;
        }

        .frontend-visibility-modal .custom-switch-description {
            display: none;
        }
    }
</style>
