<div wire:loading>
    <div class="spinner-border spinner-border-sm text-primary">
    </div>
    Loading ...
</div>
@if (flash()->message)
    <div class="text-{{ flash()->class }}" wire:loading.remove>
        {{ flash()->message }} ({{ now() }} )
    </div>
@endif
