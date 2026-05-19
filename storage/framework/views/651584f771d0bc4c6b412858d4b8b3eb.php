

<?php $__env->startSection('content'); ?>

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
            <span class="badge badge-gold" id="projCount"><?php echo e($projects->count()); ?> proyek</span>
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
            <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:#94a3b8;font-size:.82rem;"><?php echo e($project->id); ?></td>
                    <td>
                        <strong style="color:#1e293b;"><?php echo e($project->name); ?></strong>
                        <?php if($project->description): ?>
                            <br><small style="color:#64748b;"><?php echo e(Str::limit($project->description, 110)); ?></small>
                        <?php endif; ?>
                    </td>
                    <td><code style="font-size:.75rem;background:#f1f5f9;padding:.15rem .4rem;border-radius:4px;"><?php echo e($project->slug); ?></code></td>
                    <td>
                        <?php if($project->project_url): ?>
                            <a href="<?php echo e($project->project_url); ?>" target="_blank" rel="noopener"
                               class="btn btn-sm btn-outline-secondary" style="font-size:.75rem;text-decoration:none;">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Lihat
                            </a>
                        <?php else: ?>
                            <span style="color:#cbd5e1;">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:.82rem;color:#64748b;">
                        <?php echo e($project->hours_tag ?: '—'); ?> <?php echo e($project->hours_tag && $project->price_tag ? '·' : ''); ?> <?php echo e($project->price_tag ?: ''); ?>

                    </td>
                    <td>
                        <span class="badge badge-<?php echo e($project->is_active ? 'green' : 'badge-soft-red'); ?>">
                            <?php echo e($project->is_active ? 'Aktif' : 'Nonaktif'); ?>

                        </span>
                    </td>
                    <td style="text-align:center;"><?php echo e($project->order); ?></td>
                    <td class="text-end" style="white-space:nowrap;">
                        <a href="/admin/projects/<?php echo e($project->id); ?>/edit"
                           class="btn btn-outline-soft" title="Edit" style="padding:.25rem .5rem;">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="/admin/projects/<?php echo e($project->id); ?>/delete"
                              class="d-inline"
                              onsubmit="return confirm('Hapus proyek ini? Tindakan tidak dapat dibatalkan.')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm-danger" title="Hapus" style="border:none;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center py-5 text-muted">Belum ada proyek. Tambahkan proyek pertama Anda.</td></tr>
            <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Portfolio\lp-laravel\resources\views/admin/projects/list.blade.php ENDPATH**/ ?>