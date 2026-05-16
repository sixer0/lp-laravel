@extends('admin.layout')

@section('content')

<!-- Header -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h2 style="font-family:'Playfair Display',serif;color:var(--prussia-700);font-weight:800;margin-bottom:0;">
        <i class="bi bi-folder2-open me-2" style="color:var(--gold-500);"></i>Kelola Proyek
    </h2>
    <a href="/admin/projects/create" class="btn-gold">
        <i class="bi bi-plus-lg me-1"></i>Tambah Proyek
    </a>
</div>

<!-- Search / filter (client-side visual only for now) -->
<div class="admin-card mb-4" style="padding:1.2rem 1.5rem;">
    <div class="row g-2 align-items-center">
        <div class="col">
            <input type="text" id="projSearch" class="admin-input"
                   placeholder="Cari nama proyek…" style="max-width:320px;">
        </div>
        <div class="col-auto">
            <span class="badge badge-gold" id="projCount">{{ $projects->count() }} proyek</span>
        </div>
    </div>
</div>

<!-- Table -->
<div class="table-cms">
    <div class="table-responsive">
        <table class="table mb-0" id="projTable">
            <thead>
            <tr>
                <th>#</th>
                <th>Nama Proyek</th>
                <th>Slug</th>
                <th>Harga</th>
                <th>Jam &amp; Harga</th>
                <th>Status</th>
                <th>Urutan</th>
                <th class="text-end">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($projects as $project)
                <tr>
                    <td style="color:#94a3b8;font-size:.82rem;">{{ $project->id }}</td>
                    <td>
                        <strong style="color:#1e293b;">{{ $project->name }}</strong>
                        @if($project->description)
                            <br><small style="color:#64748b;">{{ Str::limit($project->description, 110) }}</small>
                        @endif
                    </td>
                    <td><code style="font-size:.75rem;background:#f1f5f9;padding:.15rem .4rem;border-radius:4px;">{{ $project->slug }}</code></td>
                    <td>
                        @if($project->project_url)
                            <a href="{{ $project->project_url }}" target="_blank" rel="noopener"
                               class="btn btn-sm btn-outline-secondary" style="font-size:.75rem;text-decoration:none;">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Lihat
                            </a>
                        @else
                            <span style="color:#cbd5e1;">—</span>
                        @endif
                    </td>
                    <td style="font-size:.82rem;color:#64748b;">
                        {{ $project->hours_tag ?: '—' }} {{ $project->hours_tag && $project->price_tag ? '·' : '' }} {{ $project->price_tag ?: '' }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $project->is_active ? 'green' : 'badge-soft-red' }}">
                            {{ $project->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="text-align:center;">{{ $project->order }}</td>
                    <td class="text-end" style="white-space:nowrap;">
                        <a href="/admin/projects/{{ $project->id }}/edit"
                           class="btn btn-outline-soft" title="Edit" style="padding:.25rem .5rem;">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="/admin/projects/{{ $project->id }}/delete"
                              class="d-inline"
                              onsubmit="return confirm('Hapus proyek ini? Tindakan tidak dapat dibatalkan.')">
                            @csrf
                            <button type="submit" class="btn btn-sm-danger" title="Hapus" style="border:none;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center py-5 text-muted">Belum ada proyek. Tambahkan proyek pertama Anda.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('projSearch')?.addEventListener('input', function () {
    var q = this.value.toLowerCase();
    var rows = document.querySelectorAll('#projTable tbody tr');
    var visible = 0;
    rows.forEach(function (r) { r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none'; if (r.style.display !== 'none') visible++; });
    document.getElementById('projCount').textContent = visible + ' proyek';
});
</script>
@endsection
