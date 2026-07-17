@extends('layouts.home')
@section('title')
  Client Add/Edit
@endsection
@section('content')

<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Management</p>
          <h1 class="h3 mb-1">{{ ($client->client_id ?? null) ? 'Edit Client' : 'Add Client' }}</h1>
          {{-- <p class="text-muted mb-0">Create a new client account with role and team assignments.</p> --}}
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('clients') }}">
            <i class="bi bi-arrow-left" aria-hidden="true"></i> 
            Back to Users
        </a>
    </div>
    </div>

    <section class="row g-3">
      <div class="col-12 col-xl-12">
        <form class="panel needs-validation" novalidate method="POST" id="clientForm">
            @csrf
            <input type="hidden" name="client_id" id="client_id" value="{{ $client->client_id ?? '' }}">
          <div class="panel-header"><div><h2 class="h5 mb-1 section-title"><i class="bi bi-person-plus" aria-hidden="true"></i><span>Client Information</span></h2><p class="text-muted mb-0">Create a client account with validated fields.</p></div></div>
          <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="client_name">Client name</label>
                <input class="form-control" id="client_name" name="client_name" value="{{ $client->client_name ?? '' }}" type="text" required>
                <div class="invalid-feedback">Please enter a valid client name.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" value="{{ $client->email ?? '' }}" type="email" required>
                <div class="invalid-feedback">Please enter email address.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="phone">Phone</label>
                <input class="form-control" id="phone" name="phone" value="{{ $client->mob ?? '' }}" type="tel" required>
                <div class="invalid-feedback">Please enter phone number.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="company">Product</label>
                <select class="form-select" id="company" name="company" required>
                    <option value="">Choose Product</option>
                    @if(!empty($companies))
                        @foreach($companies as $company)
                            <option value="{{ $company->company_id }}" {{ isset($client->company_id) && $client->company_id == $company->company_id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    @endif                    
                </select>
                {{-- <div class="invalid-feedback">Please select a company.</div> --}}
            </div>
            <div class="col-md-6">
                <label class="form-label" for="revenue_expected">Revenue Expected</label>
                <input class="form-control" id="revenue_expected" name="revenue_expected" value="{{ $client->expected_revenue ?? '' }}" type="number" required>
                <div class="invalid-feedback">Please enter expected revenue.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="dob">Date of Birth</label>
                <input class="form-control" id="dob" name="dob" value="{{ $client->dob ?? '' }}" type="date" required>
                <div class="invalid-feedback">Please enter date of birth.</div>
            </div>
            <div class="col-12">
                <label class="form-label" for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="4" placeholder="Enter client address">{{ $client->address ?? '' }}</textarea>
            </div>
          </div>
          <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
            <a class="btn btn-outline-secondary" href="{{ route('clients') }}">Cancel</a>
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-person-check" aria-hidden="true"></i> {{ isset($client->client_id) ? 'Update Client' : 'Create Client' }}
            </button>
        </div>
        </form>
      </div>
    </section>
  </div>

@endsection

@section('scripts')

<script>

    $("#clientForm").validate({
        rules: {
            client_name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            revenue_expected: {
                required: true,
                number: true
            },
            company: {
                required: true
            },
            dob: {
                required: true,
                date: true
            }   
        },
        messages: {
            client_name: {
                required: "Please enter client name",
                minlength: "Client name must be at least 3 characters"
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email"
            },
            phone: {
                required: "Please enter your phone number",
                digits: "Only digits are allowed",
                minlength: "Phone number must be 10 digits",
                maxlength: "Phone number must be 10 digits"
            },
            revenue_expected: {
                required: "Please enter expected revenue",
                number: "Please enter a valid number"
            },
            company: {
                required: "Please select a company"
            },
            dob: {
                required: "Please enter date of birth",
                date: "Please enter a valid date"
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: "{{ route('clients-add-update') }}",
                type: "POST",
                data: $(form).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            timeout: 3000
                        });
                        setTimeout(function() {
                            window.location.href = "{{ route('clients') }}";
                        }, 2000);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight',
                            timeout: 3000
                        });
                    }
                },
                error: function() {
                    alert("Something went wrong.");
                }
            });
            return false; // Prevent normal form submission
        }
    });

    {{-- function save_client(){

        $.ajax({
            url: "{{ route('clients-add') }}",
            type: "POST",
            data: $("#clientForm").serialize(),
            success: function(response) {
                // Handle success response
                console.log(response);
                alert("Client saved successfully!");
            },
            error: function(xhr, status, error) {
                // Handle error response
                // console.error(xhr.responseJSON.message);
                alert(xhr.responseJSON.message);
            }
        });
    } --}}


</script>


@endsection