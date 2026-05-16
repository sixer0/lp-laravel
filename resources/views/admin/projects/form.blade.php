@extends('admin.layout')

@section('content')
<div class="mb-4">
    <a href="/admin/projects" class="btn btn-outline-soft">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<h2 style="font-family:'Playfair Display',serif;color:var(--prussia-700);font-weight:800;margin-bottom:1.5rem;">
    <i class="bi bi-{{ $project ? 'pencil' : 'plus-circle' }} me-2" style="color:var(--gold-500);"></i>
    {{ $project ? 'Edit Proyek' : 'Tambah Proyek Baru' }}
</h2>

<div class="admin-card" style="max-width:720px;">
    <form method="POST" action="{{ $form_action }}">
        @csrf

        <div class="row g-3">
            <!-- Nama -->
            <div class="col-12">
                <label class="admin-label" for="name">Nama Proyek *</label>
                <input type="text" id="name" name="name" class="admin-input"
                       value="{{ old('name', $project->name ?? '') }}"
                       placeholder="Contoh: Website Corporate PT XYZ" required>
                @error('name') <small class="text-danger" style="font-size:.78rem;">{{ $message }}</small> @enderror
            </div>

            <!-- Deskripsi -->
            <div class="col-12">
                <label class="admin-label" for="description">Deskripsi</label>
                <textarea id="description" name="description" class="admin-input" rows="4"
                          placeholder="Ringkasan proyek singkat yang akan ditampilkan di landing page…">{{ old('description', $project->description ?? '') }}</textarea>
                @error('description') <small class="text-danger" style="font-size:.78rem;">{{ $message }}</small> @enderror
            </div>

            <!-- Link Projekt & Gambar -->
            <div class="col-md-6">
                <label class="admin-label" for="slug">Slug</label>
                <input type="text" id="slug" name="slug" class="admin-input"
                       value="{{ old('slug', $project->slug ?? '') }}"
                       placeholder="otomatis dari nama jika kosong">
                @if($project ?? null)
                    <small class="text-muted" style="font-size:.72rem;">kosongkan untuk auto-generate dari nama</small>
                @endif
            </div>
            <div class="col-md-6">
                <label class="admin-label" for="order">Urutan Tampilan</label>
                <input type="number" id="order" name="order" class="admin-input"
                       value="{{ old('order', $project->order ?? ($projects_total ?? 1)) }}"
                       min="0" max="999">
            </div>
            <div class="col-md-6">
                <label class="admin-label" for="image">URL Gambar</label>
                <input type="url" id="image" name="image" class="admin-input"
                       value="{{ old('image', $project->image ?? '') }}"
                       placeholder="https://…">
            </div>
            <div class="col-md-6">
                <label class="admin-label" for="project_url">URL Proyek Eksternal</label>
                <input type="url" id="project_url" name="project_url" class="admin-input"
                       value="{{ old('project_url', $project->project_url ?? '') }}"
                       placeholder="https://…">
            </div>
            <div class="col-md-6">
                <label class="admin-label" for="hours_tag">Label Jam</label>
                <input type="text" id="hours_tag" name="hours_tag" class="admin-input"
                       value="{{ old('hours_tag', $project->hours_tag ?? '') }}"
                       placeholder="Contoh: ~120 jam">
            </div>
            <div class="col-md-6">
                <label class="admin-label" for="price_tag">Label Harga</label>
                <input type="text" id="price_tag" name="price_tag" class="admin-input"
                       value="{{ old('price_tag', $project->price_tag ?? '') }}"
                       placeholder="Contoh: Rp 25jt">
            </div>

            <!-- Status -->
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                              value="1" {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }}
                                style="border-color:#d4a843;accent-color:#d4a843;width:18px;height:18px;">
                    <label class="form-check-label" for="is_active"
                           style="font-size:.88rem;color:#475569;">
                        Tampilkan di landing page
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="col-12 mt-4">
                <button type="submit" class="btn-gold me-2">
                    <i class="bi bi-check-lg me-1"></i>{{ $project ? 'Simpan Perubahan' : 'Tambah Proyek' }}
                </button>
                <a href="/admin/projects" class="btn btn-outline-soft">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
