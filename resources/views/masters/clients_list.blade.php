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
          <p class="eyebrow mb-1">Management</p>
          <h1 class="h3 mb-1">Users</h1>
          <p class="text-muted mb-0">Review accounts, roles, account status, and team ownership.</p>
        </div>
      </div>
      {{-- <div class="heading-actions">
            <a class="btn btn-outline-secondary btn-sm" href="tables.html">
                <i class="bi bi-download" aria-hidden="true"></i> 
                Export
            </a>
            <a class="btn btn-primary btn-sm" href="{{ route('clients-add-edit') }}">
                <i class="bi bi-person-plus" aria-hidden="true"></i> 
                Add User
            </a>
        </div> --}}
    </div>

    {{-- <section class="row g-3 mt-1" aria-label="User summary">
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-primary">
          <div class="metric-top">
            <span class="metric-label">Total Users</span>
            <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">8,742</div>
          <div class="metric-meta">
            <span class="text-success">+5.1%</span>
            <span>this month</span>
          </div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-success">
          <div class="metric-top">
            <span class="metric-label">Active</span>
            <span class="metric-icon"><i class="bi bi-check2-circle" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">7,980</div>
          <div class="metric-meta">
            <span class="text-success">91%</span>
            <span>healthy accounts</span>
          </div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-warning">
          <div class="metric-top">
            <span class="metric-label">Pending</span>
            <span class="metric-icon"><i class="bi bi-hourglass-split" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">184</div>
          <div class="metric-meta">
            <span class="text-warning">12</span>
            <span>need approval</span>
          </div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-danger">
          <div class="metric-top">
            <span class="metric-label">Suspended</span>
            <span class="metric-icon"><i class="bi bi-slash-circle" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">38</div>
          <div class="metric-meta">
            <span class="text-danger">4</span>
            <span>flagged today</span>
          </div>
        </article>
      </div>
    </section> --}}

    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>User List</span></h2>
          <p class="text-muted mb-0">Search, review, and manage team member accounts.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
          {{-- <input class="form-control form-control-sm table-search" type="search" placeholder="Search users" data-table-search="usersTable" aria-label="Search users"> --}}
          <a class="btn btn-primary btn-sm" href="{{ route('clients-add-edit') }}">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add Client</a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0" id="clientTable" data-searchable-table>
          <thead>
            <tr>
              <th scope="col" style="width: 2%;text-align: center;">Sr. No.</th>
              <th scope="col" style="width: 10%;text-align: center;">Client Name</th>
              <th scope="col" style="width: 7%;text-align: center;">Company</th>
              <th scope="col" style="width: 5%;text-align: center;">Email</th>
              <th scope="col" style="width: 5%;text-align: center;">Mobile</th>
              <th scope="col" style="width: 5%;text-align: center;">Action</th>
            </tr>
          </thead>
          <tbody>            
          </tbody>
        </table>
      </div>
    </section>
  </div>
@endsection
@section('scripts')
<script>
console.log('test');
const table = $('#clientTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route("clients-list") }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'client_name',
                name: 'client_name'
            },
            {
                data: 'company_name',
                name: 'company_name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'mobile',
                name: 'mobile'
            },
            {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }
        ]
    });

    function deleteClient(clientId) {
        if (confirm('Are you sure you want to delete this client?')) {
            $.ajax({
                url: '{{ route("client-delete") }}',
                type: 'POST',
                data: {
                    client_id: clientId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                  if(response.status) {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            timeout: 2500
                        });
                        table.ajax.reload();
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight',
                            timeout: 2500
                        });
                    }
                    
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the client.');
                }
            });
        }
    }

    function whatsApp_messages(number){
        var url = "https://api.whatsapp.com/send?phone="+number;
        window.open(url, '_blank');
    }

</script>

@endsection