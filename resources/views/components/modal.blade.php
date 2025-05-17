<div class="modal d-block" style="background: rgba(0, 0, 0, 0.5);overflow-y: auto;">
    <div class="modal-dialog @isset($size)modal-{{ $size }} @endisset">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header @isset($theme)bg-{{ $theme }} text-white @endisset">
                    <h5 class="modal-title">
                        @isset($icon)
                            <i class="{{ $icon }} mr-2"></i>
                        @endisset
                        @isset($title)
                            {{ $title }}
                        @endisset
                    </h5>
                </div>
                @if (!$slot->isEmpty())
                    <div class="modal-body">{{ $slot }}</div>
                @endif
                <div class="modal-footer">
                    <x-footer-card-message />
                    @isset($footerSlot)
                        {{ $footerSlot }}
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
