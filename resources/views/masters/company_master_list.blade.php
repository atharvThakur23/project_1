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
          <input class="form-control form-control-sm table-search" type="search" placeholder="Search Company" data-table-search="usersTable" aria-label="Search users">
          <a class="btn btn-primary btn-sm" href="#" onclick="openmodal()">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add Company</a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0" id="companyTable" data-searchable-table>
          <thead>
            <tr>
                <th scope="col">Sr.</th>
                <th scope="col">Company Name</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
      </div>
      <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
        <p class="text-muted small mb-0">Showing 1 to 5 of 124 users</p>
        <nav aria-label="Users pagination"><ul class="pagination pagination-sm mb-0"><li class="page-item disabled"><a class="page-link" href="#">Previous</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Next</a></li></ul></nav>
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
                    <div class="pm-form-group">
                        <label class="pm-label">Company Name</label>
                        <input type="text" class="form-control pm-input" id="pm_name" name="name" placeholder="Enter company name">
                    </div>

                    <div class="pm-form-group">
                        <label class="pm-label">Status</label>
                        <select class="form-control pm-input" id="pm_status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
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
@section('scripts')
<script>
    fetchCompanies();
    function fetchCompanies(){
        $.ajax({
            url: '{{ route("company-list") }}',
            method: 'GET',
            success: function(response) {
                // Assuming the response contains an array of companies
                var companies = response;
                var tbody = $('#companyTable tbody');
                tbody.empty(); // Clear existing rows

                companies.forEach(function(company, index) {
                    var row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + company.company_name + '</td>' +
                        '<td>' + company.status + '</td>' +
                        '<td class="text-end"><a class="btn btn-light btn-sm" href="#">View</a></td>' +
                        '</tr>';
                    tbody.append(row);
                });
            },
            error: function(xhr) {
                console.error('Failed to fetch companies.');
            }
        });
    }
    function openmodal() {
        $("#pmUserModal").modal("show");
    }

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

    function saveCompany() {
        if ($('#addCompanyForm').valid()) {
            var name = $('#pm_name').val();
            var status = $('#pm_status').val();

            // Perform AJAX request to save the company data
            $.ajax({
                url: '{{ route("company-save") }}',
                method: 'POST',
                data: {
                    name: name,
                    status: status,
                    _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                success: function(response) {
                    // Handle success response
                    // const notyf = new Notyf();
                    // notyf.success('Company saved successfully!');

                    iziToast.success({
                        title: 'Success',
                        message: 'Company saved successfully!',
                        position: 'topRight',
                        timeout: 3000
                    });
                    
                    $("#pmUserModal").modal("hide");
                },
                error: function(xhr) {
                    
                    // const notyf = new Notyf();
                    // notyf.error('Failed to save company.');

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

</script>
@endsection