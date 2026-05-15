@extends('layouts.guest')

@section('title', 'Legal Notice - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h1 class="fw-bold mb-4">Legal Notice</h1>
                    
                    <h5 class="mt-4">Information according to § 5 TMG</h5>
                    <p>
                        <strong>Budi Kusharyanto</strong><br>
                        IT Consultant & Software Developer<br>
                        Tangerang, Indonesia<br>
                        Email: sixer0.bk@gmail.com
                    </p>

                    <h5 class="mt-4">Responsible for Content</h5>
                    <p>Budi Kusharyanto</p>

                    <h5 class="mt-4">Disclaimer</h5>
                    <p>
                        The contents of these pages have been prepared with the greatest possible care. 
                        However, no guarantee is given for the accuracy, completeness, or up-to-dateness 
                        of the information provided.
                    </p>

                    <h5 class="mt-4">Liability for Content</h5>
                    <p>
                        As a service provider, we are responsible for our own content on these pages 
                        in accordance with § 7 paragraph 1 of the German Media Services Treaty (TMG). 
                        However, we are not obligated to monitor transmitted or stored external information 
                        or to investigate circumstances that indicate illegal activity.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
