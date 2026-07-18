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
      
    </div>


    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>User List</span></h2>
          <p class="text-muted mb-0">Search, review, and manage team member accounts.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-success btn-sm" onclick="openmodal()">
            <i class="bi bi-file-earmark-spreadsheet" aria-hidden="true"></i> 
            Uploads Clients
          </button>
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
              <th scope="col" style="width: 7%;text-align: center;">Product</th>
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

  <!-- PM Modal -->
  <div class="modal fade" id="uploadClientsModal" tabindex="-1" aria-labelledby="pmUserModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered pm-modal-dialog">
          <div class="modal-content pm-modal-content">
  
              <div class="modal-header pm-modal-header">
                  <h5 class="modal-title" id="pmUserModalLabel">Upload Clients</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
  
              <div class="modal-body">
                  <form id="uploadClientsForm" method="POST" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" id="pm_company_id" name="company_id" value="">
                      <div class="pm-form-group">
                          {{-- <label class="pm-label">Download Template</label> --}}
                          <a href="{{ asset('uploads/client.xlsx') }}" class="btn btn-primary" download>
                              <i class="bi bi-download" aria-hidden="true"></i> Download Template
                          </a>
                      </div>
  
                      <div class="pm-form-group">
                          <label class="pm-label">Upload</label>
                          <input type="file" class="form-control pm-input" id="pm_upload" name="upload" accept=".xlsx, .xls">
                      </div>
                  </form>
              </div>
  
              <div class="modal-footer pm-modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  
                  <button type="button" class="btn btn-primary pm-save-btn" onclick="saveClients()">
                      Save
                  </button>
              </div>
  
          </div>
      </div>
  </div>
@endsection
@section('scripts')
<script>

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

    function openmodal() {
        $("#uploadClientsModal").modal("show");
    }

    function saveClients(){

      $.ajax({
          url: '{{ route("upload-client") }}',
          type: 'POST',
          data: new FormData($('#uploadClientsForm')[0]),
          processData: false,
          contentType: false,
          success: function(response) {
              if(response.status) {
                  iziToast.success({
                      title: 'Success',
                      message: response.message,
                      position: 'topRight',
                      timeout: 2500
                  });
                  table.ajax.reload();
                  $("#uploadClientsModal").modal("hide");
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
              alert('An error occurred while uploading the clients.');
          }
      });

    }

</script>

@endsection