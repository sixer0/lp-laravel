@extends('layouts.guest')

@section('title', $project->name ?? 'Project')

@section('content')
<section class="py-5 bg-white">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Projects</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $project->name ?? 'Project' }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Image -->
            <div class="col-lg-6">
                @if(!empty($project->image))
                <img src="{{ $project->image }}"
                     alt="{{ $project->name ?? 'Project' }}"
                     class="img-fluid w-100 rounded-3 shadow-sm">
                @else
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                     style="min-height: 300px;">
                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                </div>
                @endif
            </div>

            <!-- Details -->
            <div class="col-lg-6">
                <h1 class="display-6 fw-bold mb-3" style="color: var(--color-dark);">
                    {{ $project->name ?? 'Project' }}
                </h1>

                <div class="d-flex gap-3 mb-4">
                    @if(!empty($project->hours_tag))
                    <span class="badge rounded-pill px-3 py-2" style="background: var(--color-primary);">
                        <i class="bi bi-clock me-1"></i>{{ $project->hours_tag }}
                    </span>
                    @endif
                    @if(!empty($project->price_tag))
                    <span class="badge rounded-pill px-3 py-2"
                          style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white;">
                        <i class="bi bi-tag me-1"></i>{{ $project->price_tag }}
                    </span>
                    @endif
                </div>

                <div class="mb-4">
                    {!! nl2br(e($project->description)) !!}
                </div>

                @if(!empty($project->project_url))
                <a href="{{ $project->project_url }}"
                   class="btn btn-primary btn-lg rounded-pill px-5"
                   target="_blank"
                   rel="noopener"
                   style="background: linear-gradient(135deg, #2563eb, #0d6efd); border: none;">
                    View Project <i class="bi bi-box-arrow-up-right ms-2"></i>
                </a>
                @else
                <a href="{{ route('home') }}"
                   class="btn btn-outline-primary btn-lg rounded-pill px-5">
                    <i class="bi bi-arrow-left me-2"></i>Back to Projects
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
