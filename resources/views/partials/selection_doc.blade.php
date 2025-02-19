<div class="container">
    <h1 class="text-center mb-4">اختر المستندات المطلوبة</h1>
    <form method="POST" action="{{ route('certificats.store-documents', $certificat->id) }}">
        @csrf

        <ul class="list-group">
            @foreach($documents as $document)
                <li class="list-group-item">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="selected_documents[]"
                            value="{{ $document->id }}"
                            id="doc-{{ $document->id }}"
                            {{ in_array($document->id, $selectedDocumentIds) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="doc-{{ $document->id }}">
                            {{ $document->name }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        <button type="submit" class="btn btn-primary mt-3">
            <i class="fas fa-save me-2"></i>حفظ المستندات
        </button>
    </form>
</div>