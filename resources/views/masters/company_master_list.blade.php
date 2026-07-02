@extends('layouts.home')
@section('title')
  Clients
@endsection
@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Masters</p>
          <h1 class="h3 mb-1">Company</h1>
        </div>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i>
            <span>Company List</span>
        </h2>
        </div>
        <div class="d-flex flex-wrap gap-2">
          {{-- <input class="form-control form-control-sm table-search" type="search" placeholder="Search Company" data-table-search="usersTable" aria-label="Search users"> --}}
          <a class="btn btn-primary btn-sm" href="#" onclick="openmodal()">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add Company</a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0" id="companyTable" data-searchable-table>
          <thead>
            <tr>
                <th scope="col" style="width: 2%;text-align: center;">Sr.</th>
                <th scope="col" style="width: 40%;text-align: center;">Company Name</th>
                <th scope="col" style="width: 5%;text-align: center;">Status</th>
                <th scope="col" style="width: 5%;text-align: center;">Actions</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
      </div>
    </section>
  </div>

  <!-- PM Modal -->
<div class="modal fade" id="pmUserModal" tabindex="-1" aria-labelledby="pmUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pm-modal-dialog">
        <div class="modal-content pm-modal-content">

            <div class="modal-header pm-modal-header">
                <h5 class="modal-title" id="pmUserModalLabel">Company Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addCompanyForm" method="POST">
                    <input type="hidden" id="pm_company_id" name="company_id" value="">
                    <div class="pm-form-group">
                        <label class="pm-label">Company Name</label>
                        <input type="text" class="form-control pm-input" id="pm_name" name="name" placeholder="Enter company name">
                    </div>

                    <div class="pm-form-group">
                        <label class="pm-label">Status</label>
                        <select class="form-control pm-input" id="pm_status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer pm-modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary pm-save-btn" onclick="saveCompany()">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script> --}}
@section('scripts')
<script>
    fetchCompanies();
    const table = $('#companyTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route("company-list") }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'company_name',
                name: 'company_name'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }
        ]
    });
    function fetchCompanies(){
        
    }
    function openmodal() {
        $("#pmUserModal").modal("show");
    }    

    function saveCompany() {
        $('#addCompanyForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                status: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter the company name",
                    minlength: "Company name must be at least 2 characters long"
                },
                status: {
                    required: "Please select a status"
                }
            },
        });
        if ($('#addCompanyForm').valid()) {
            var name = $('#pm_name').val();
            var status = $('#pm_status').val();
            let company_id = $('#pm_company_id').val();
            console.log("Company ID:", company_id);
            let url = '';
            let data = {};
            if(company_id != ''){
                url = '{{ route("company-update") }}';
                console.log("Company ID:", url);
                data = {
                    company_id: company_id,
                    name: name,
                    status: status,
                    _token: '{{ csrf_token() }}'
                };
            }else{
                url = '{{ route("company-save") }}';
                data = {
                    name: name,
                    status: status,
                    _token: '{{ csrf_token() }}'
                };
            }
            console.log("Company ID:", url);
            // Perform AJAX request to save the company data
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(response) {
                    
                    // const notyf = new Notyf();
                    // notyf.success('Company saved successfully!');
                    if(response.status){                       
                        table.ajax.reload(null, false);
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            timeout: 3000
                        });
                        
                        $("#pmUserModal").modal("hide");
                    }else{
                        
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight',
                            timeout: 3000
                        });
                    }
                    
                    
                },
                error: function(xhr) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Failed to save company.',
                        position: 'topRight',
                        timeout: 3000
                    });
                }
            });
        }
    }   

    function editCompany(companyId) {
        // Perform AJAX request to fetch company data by ID
        $.ajax({
            url: '{{ route("company-data") }}',
            method: 'GET',
            data: {
                company_id: companyId
            },
            success: function(response) {
                // Handle success response
                if(response.status) {
                    $('#pm_name').val(response.data.company_name);
                    $('#pm_status').val(response.data.status);
                    $('#pm_company_id').val(response.data.company_id);
                    $("#pmUserModal").modal("show");                    
                }else{
                    iziToast.error({
                        title: 'Error',
                        message: 'Company not found.',
                        position: 'topRight',
                        timeout: 3000
                    });
                }                
            },
            error: function(xhr) {
                // Handle error response
                iziToast.error({
                    title: 'Error',
                    message: 'Failed to fetch company data.',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        });
    }

    function deleteCompany(companyId) {
        if(confirm("Are you sure you want to delete this company?")) {
            $.ajax({
                url: '{{ route("company-delete") }}',
                method: 'POST',
                data: {
                    company_id: companyId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.status) {
                        table.ajax.reload(null, false);
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            timeout: 3000
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight',
                            timeout: 3000
                        });
                    }
                },
                error: function(xhr) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Failed to delete company.',
                        position: 'topRight',
                        timeout: 3000
                    });
                }
            });
        }
    }

</script>
@endsection