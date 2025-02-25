@extends('layouts.app')

@push('content')
<div class="container">
    <h1 class="mb-4">Certificate Details</h1>
    
    <div class="card">
        <div class="card-body">
            @if($certificate)
                <h5 class="card-title">Certificate Information</h5>
                <dl class="row">
                    <dt class="col-sm-3">Issued To:</dt>
                    <dd class="col-sm-9">{{ $certificate->user->name }}</dd>

                    <dt class="col-sm-3">Issue Date:</dt>
                    <dd class="col-sm-9">{{ $certificate->created_at->format('Y-m-d') }}</dd>

                    <dt class="col-sm-3">Certificate Hash:</dt>
                    <dd class="col-sm-9"><code>{{ $certificate->hash }}</code></dd>

                    <!-- Add more certificate fields as needed -->
                </dl>
            @else
                <div class="alert alert-danger">
                    Certificate not found
                </div>
            @endif
            
            <a href="{{ route('certificats.scan.form') }}" class="btn btn-primary">
                Scan Another
            </a>
        </div>
    </div>
</div>
@endpush