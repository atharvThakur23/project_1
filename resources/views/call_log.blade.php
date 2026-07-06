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
          <h1 class="h3 mb-1">Call Log</h1>
          <p class="text-muted mb-0">Review call logs and manage call-related information.</p>
        </div>
      </div>
      <div class="heading-actions">
            {{-- <a class="btn btn-outline-secondary btn-sm" href="tables.html">
                <i class="bi bi-download" aria-hidden="true"></i> 
                Export
            </a> --}}
            <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="openmodal()">
                <i class="bi bi-person-plus" aria-hidden="true"></i> 
                Tag Call
            </a>
        </div>
    </div>

    <section class="row g-3 mt-1" aria-label="User summary">
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-primary">
          <div class="metric-top">
            <span class="metric-label">Total Users</span>
            <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ number_format($clientCout) }}</div>
          {{-- <div class="metric-meta">
            <span class="text-success">+5.1%</span>
            <span>this month</span>
          </div> --}}
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-success">
          <div class="metric-top">
            <span class="metric-label">Todays Follow-ups</span>
            <span class="metric-icon"><i class="bi bi-check2-circle" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ number_format($followUpCount) }}</div>
          {{-- <div class="metric-meta">
            <span class="text-success">91%</span>
            <span>healthy accounts</span>
          </div> --}}
        </article>
      </div>

      {{-- <div class="col-12 col-sm-6 col-xl-3">
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
      </div> --}}
    </section>

    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Call History</span></h2>
          {{-- <p class="text-muted mb-0">Search, review, and manage team member accounts.</p> --}}
        </div>
        {{-- <div class="d-flex flex-wrap gap-2">
          <input class="form-control form-control-sm table-search" type="search" placeholder="Search users" data-table-search="usersTable" aria-label="Search users">
          <a class="btn btn-primary btn-sm" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#tagCallModal">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Tag Call</a>
        </div> --}}
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0" id="clientTable" data-searchable-table>
          <thead>
            <tr>
              <th scope="col" style="width: 2%;text-align: center;">Sr. No.</th>
              <th scope="col" style="width: 10%;text-align: center;">Client Details</th>
              <th scope="col" style="width: 7%;text-align: center;">Mobile/Email</th>
              <th scope="col" style="width: 5%;text-align: center;">Last Tag</th>
              <th scope="col" style="width: 5%;text-align: center;">Remark</th>
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
<div class="modal fade" id="callTagModel" tabindex="-1" aria-labelledby="callTagModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pm-modal-dialog">
        <div class="modal-content pm-modal-content">

            <div class="modal-header pm-modal-header">
                <h5 class="modal-title" id="callTagModelLabel">Tag a Call</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="callLogForm" method="POST">
                    @csrf
                    <input type="hidden" id="pm_company_id" name="company_id" value="">
                    <div class="pm-form-group">
                        <label class="pm-label" for="client">Search Client</label>
                        <select class="form-control pm-input select2" style="width:100%" id="client" name="client">
                        </select>
                    </div>

                    <div class="pm-form-group">
                        <label class="pm-label">Status</label>
                        <select class="form-control pm-input" id="status" name="status" onchange="changeTag(this.value)">
                            <option value="">Select Status</option>
                            <option value="1">Contacted</option>
                            <option value="0">Not Contacted</option>
                        </select>
                    </div>
                    <div class="pm-form-group">
                        <label class="pm-label">Call Tag</label>
                        <select class="form-control pm-input" id="call_tag" name="call_tag" onchange="changeCallTag(this.value)">
                            <option value="">Select Call Tag</option>
                        </select>
                    </div>
                    <div class="pm-form-group" style="display:none" id="follow_up_date_div">
                        <label class="pm-label">Follow-up Date</label>
                        <input type="date" class="form-control pm-input" id="follow_up_date" name="follow_up_date">
                    </div>

                    <div class="pm-form-group">
                        <label class="pm-label">Remark</label>
                        <textarea class="form-control pm-input" id="remark" name="remark"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer pm-modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary pm-save-btn" onclick="saveCallLog()">
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
        ajax: "{{ route("call-history") }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'client_details',
                name: 'client_details'
            },
            {
                data: 'mob_email',
                name: 'mob_email'
            },
            {
                data: 'last_tag',
                name: 'last_tag'
            },
            {
                data: 'remark',
                name: 'remark'
            },
            {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }
        ]
    });
    $(document).ready(function () {
        
        $('#client').select2({
            dropdownParent: $('#callTagModel'),
            placeholder: 'Search Client',
            minimumInputLength: 2, // Search after 2 characters
            ajax: {
                url: "{{ route('client-search') }}",
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });

    function openmodal() {
        $("#callTagModel").modal("show");
    }   

    function changeTag(value) {
        $.ajax({
            url: "{{ route('get-tags') }}",
            type: 'post',
            data: { status: value,
                    _token: '{{ csrf_token() }}'
             },
            success: function (data) {
                $('#call_tag').empty();
                $('#call_tag').append('<option value="">Select Call Tag</option>');
                $.each(data, function (key, value) {
                    $('#call_tag').append('<option value="' + value.tag_id + '">' + value.tag_name + '</option>');
                });
            }
        });
    }

    function changeCallTag(value) {
        if(value == 7) {
            $('#follow_up_date_div').show();
        } else {
            $('#follow_up_date_div').hide();
        }
    }

    function saveCallLog() {
        $('#callLogForm').validate({
            rules: {
                client: {
                    required: true
                },
                call_tag: {
                    required: true
                },
                status: {
                    required: true
                },
                call_tag: {
                    required: true
                }
                
            },
            messages: {
                client: {
                    required: "Please enter the client name",
                    minlength: "Client name must be at least 2 characters long"
                },
                call_tag: {
                    required: "Please select a call tag"
                },
                status: {
                    required: "Please select a status"
                },
                call_tag: {
                    required: "Please select a call tag"
                }
            },
        });
        if ($('#callLogForm').valid()) {
            var formData = $('#callLogForm').serialize();
            if($('#follow_up_date_div').is(':visible')) {
                if($('#follow_up_date').val() == '') {
                    alert('Please select a follow-up date');
                    return false;
                }
            }
            $.ajax({
                url: "{{ route('save-call-log') }}",
                type: 'post',
                data: formData,
                success: function (data) {
                    
                    if(data.status){
                        iziToast.success({
                            title: 'Success',
                            message: data.message,
                            position: 'topRight'
                        });
                        table.ajax.reload(null, false);
                        $('#callTagModel').modal('hide');
                    }else{
                        iziToast.error({
                            title: 'Error',
                            message: data.message,
                            position: 'topRight'
                        });
                    }    
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