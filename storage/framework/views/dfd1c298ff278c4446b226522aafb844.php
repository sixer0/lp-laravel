

<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h2 style="font-family:'Playfair Display',serif;color:var(--prussia-700);font-weight:800;">
        Selamat Datang, <?php echo e($admin_user['name'] ?? 'Admin'); ?> 👋
    </h2>
    <p class="text-muted mb-0">Kelola konten landing page Sixer0 dari sini.</p>
</div>

<!-- Dashboard Quick Actions -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <a href="/admin/projects" style="text-decoration:none;color:inherit;">
                <div class="stat-icon"><i class="bi bi-folder2-open"></i></div>
                <div class="stat-value"><?php echo e($projects_total); ?></div>
                <div class="stat-label">Total Proyek</div>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-check2-circle" style="color:#22c55e;"></i></div>
            <div class="stat-value"><?php echo e($projects_active); ?></div>
            <div class="stat-label">Proyek Aktif</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-envelope-fill" style="color:#3b82f6;"></i></div>
            <div class="stat-value"><?php echo e($messages_unread); ?></div>
            <div class="stat-label">Pesan Baru</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people-fill" style="color:#8b5cf6;"></i></div>
            <div class="stat-value"><?php echo e($users_total); ?></div>
            <div class="stat-label">Pengguna</div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="admin-card">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-palette me-2" style="color:var(--gold-500);font-size:1.3rem;"></i>
                <h5 class="mb-0" style="color:var(--prussia-700);">Edit Konten Landing</h5>
            </div>
            <p class="text-muted small mb-3">Ubah teks hero, deskripsi layanan, dan semua konten halaman utama.</p>
            <a href="/admin/projects/create" class="btn-gold">
                <i class="bi bi-plus-circle me-1"></i>Tambah Proyek
            </a>
            <a href="/admin/projects" class="btn btn-outline-soft ms-2">Lihat Semua</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-card">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-eye me-2" style="color:var(--gold-500);font-size:1.3rem;"></i>
                <h5 class="mb-0" style="color:var(--prussia-700);">Preview Situs</h5>
            </div>
            <p class="text-muted small mb-3">Lihat langsung perubahan di halaman publik Sixer0.</p>
            <a href="/" target="_blank" class="btn btn-outline-soft">
                <i class="bi bi-box-arrow-up-right me-1"></i>Buka Halaman
            </a>
            <a href="/privacy" class="btn btn-outline-soft ms-2">Kebijakan Privasi</a>
        </div>
    </div>
</div>

<!-- Recent Messages -->
<div class="row g-3">
    <div class="col-lg-6">
        <div class="admin-card">
            <h6 class="mb-3" style="color:var(--prussia-700);">
                <i class="bi bi-chat-dots me-1" style="color:var(--gold-500);"></i>Pesan Terbaru
            </h6>
            <?php $__empty_1 = true; $__currentLoopData = $recent_messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div style="border-bottom:1px solid #f1f5f9;padding:.65rem 0;">
                <div style="font-size:.82rem;font-weight:600;color:#1e293b;"><?php echo e($msg->name); ?> <span class="badge badge-<?php echo e($msg->status === 'new' ? 'gold' : 'green'); ?>"><?php echo e($msg->status); ?></span></div>
                <div style="font-size:.78rem;color:#64748b;"><?php echo e(str($msg->message)->limit(90)); ?></div>
                <div style="font-size:.72rem;color:#94a3b8;"><?php echo e($msg->created_at?->diffForHumans()); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted small mb-0">Belum ada pesan contact.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card">
            <h6 class="mb-3" style="color:var(--prussia-700);">
                <i class="bi bi-folder me-1" style="color:var(--gold-500);"></i>Proyek Terbaru
            </h6>
            <?php $__empty_1 = true; $__currentLoopData = $recent_projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div style="border-bottom:1px solid #f1f5f9;padding:.65rem 0;">
                <div style="font-size:.82rem;font-weight:600;color:#1e293b;"><?php echo e($project->name); ?></div>
                <div style="font-size:.78rem;color:#64748b;"><?php echo e(str($project->description)->limit(90)); ?></div>
                <div style="font-size:.72rem;color:#94a3b8;">
                    <span class="badge badge-<?php echo e($project->is_active ? 'green' : 'badge-soft-red'); ?>">
                        <?php echo e($project->is_active ? 'Aktif' : 'Nonaktif'); ?>

                    </span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted small mb-0">Belum ada proyek aktif.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sixq7133/public_html/landing.sixer0-bk.my.id/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>