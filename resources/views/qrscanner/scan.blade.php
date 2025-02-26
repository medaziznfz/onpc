@extends('layouts.app')

@push('styles')
<style>
    #video-container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: auto;
    }

    video {
        width: 100%;
        border-radius: 10px;
        border: 3px solid #007bff;
        transform: scaleX(-1); /* Apply mirror effect */
    }

    .scanner-frame {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50vw;
        height: 50vw;
        max-width: 250px;
        max-height: 250px;
        border: 4px dashed red;
        border-radius: 5px;
        display: none; /* Initially hidden */
    }

    #scan-result {
        font-size: 20px;
        font-weight: bold;
        word-wrap: break-word; /* Ensure long words break */
        overflow-wrap: break-word; /* Alternative for word-breaking */
        max-width: 100%; /* Prevent text from overflowing */
        white-space: pre-wrap; /* Preserve spaces and line breaks */
    }

    #switch-camera {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        display: none; /* Initially hidden */
    }
</style>
@endpush

@push('content')
<div class="container text-center">
    <h1 class="mb-4">مسح رمز QR</h1>
    <p>ضع رمز QR داخل الإطار لمسحه ضوئيًا</p>

    <div id="video-container">
        <video id="preview"></video>
        <div class="scanner-frame" id="scanner-frame"></div>
        <button id="switch-camera" class="btn btn-secondary">تبديل الكاميرا</button>
    </div>

    <p id="scan-result" class="mt-3 text-success text-break w-100"></p>
</div>
@endpush

@push('scripts')
<script src="{{ asset('js/instascan.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        let cameras = [];
        let currentCameraIndex = 0;
        let scannerFrame = document.getElementById('scanner-frame');
        let scanResult = document.getElementById('scan-result');
        let switchCameraButton = document.getElementById('switch-camera');
        let videoElement = document.getElementById('preview');

        scanner.addListener('scan', function (content) {
            scanResult.innerText = "تم المسح بنجاح: " + content;

            // Wait 2 seconds before redirecting
            setTimeout(() => {
                window.location.href = "{{ route('qrscanner.show', '') }}/" + encodeURIComponent(content);
            }, 1000);
        });

        Instascan.Camera.getCameras().then(function (availableCameras) {
            if (availableCameras.length > 0) {
                cameras = availableCameras;

                // Set the back camera as the default if it exists
                let backCamera = cameras.find(camera => camera.name.toLowerCase().includes('back'));
                if (backCamera) {
                    currentCameraIndex = cameras.indexOf(backCamera);
                }
                
                scanner.start(cameras[currentCameraIndex]).then(() => {
                    scannerFrame.style.display = 'block';
                });

                // Show the switch camera button if there are multiple cameras
                if (cameras.length > 1) {
                    switchCameraButton.style.display = 'block';
                }
            } else {
                alert("لم يتم العثور على كاميرا");
            }
        }).catch(function (e) {
            console.error(e);
            alert("حدث خطأ أثناء محاولة الوصول إلى الكاميرا.");
        });

        switchCameraButton.addEventListener('click', function () {
            currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
            scanner.start(cameras[currentCameraIndex]).then(() => {
                scannerFrame.style.display = 'block';
            });
        });
    });
</script>
@endpush
