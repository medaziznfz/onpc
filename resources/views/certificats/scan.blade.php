@extends('layouts.app')

@push('content')
<div class="container">
    <h1 class="mb-4">Scan Certificate QR Code</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div id="qr-scanner">
                <video id="preview" class="w-100" style="max-width: 500px;"></video>
            </div>
            <p class="text-muted mt-2">Point your camera at the QR code</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Manual Entry</h5>
            <form action="{{ route('certificats.details') }}" method="GET">
                <div class="form-group">
                    <input type="text" name="hash" class="form-control" 
                           placeholder="Enter certificate hash" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    View Details
                </button>
            </form>
        </div>
    </div>
</div>
@endpush


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
<script>
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview'),
        mirror: false
    });

    scanner.addListener('scan', function(content) {
        window.location.href = "{{ route('certificats.details') }}?hash=" + 
                             encodeURIComponent(content);
    });

    Instascan.Camera.getCameras()
        .then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[cameras.length > 1 ? 1 : 0]); // Prefer rear camera
            } else {
                console.error('No cameras found');
                alert('No camera access - please enable camera permissions');
            }
        })
        .catch(function(e) {
            console.error(e);
            alert('Camera access error: ' + e.message);
        });
</script>
@endpush