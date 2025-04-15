<div class="row">
    <p class="card-text placeholder-glow col-6"></p>
    <p class="card-text placeholder-glow col-7"></p>
    <p class="card-text placeholder-glow col-4"></p>
    <p class="card-text placeholder-glow col-4"></p>
    <p class="card-text placeholder-glow col-6"></p>
    <p class="card-text placeholder-glow col-8"></p>
    <br>
</div>
@push('css')
    <style>
        .placeholder {
            display: inline-block;
            width: 100%;
            height: 1em;
            background-color: #e9ecef;
            border-radius: 0.2rem;
        }

        .placeholder-glow::before {
            content: "\00a0";
            display: inline-block;
            width: 100%;
            height: 100%;
            background-color: #e9ecef;
            border-radius: inherit;
            animation: glow 1.5s infinite linear;
        }

        @keyframes glow {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
@endpush
