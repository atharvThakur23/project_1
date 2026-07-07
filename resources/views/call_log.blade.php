@extends('layouts.home')
@section('title')
  Clients
@endsection

<style>
.bsb-timeline-8 {
    --bsb-tl-color: var(--bs-primary-bg-subtle);
    --bsb-tl-circle-color: var(--bs-light);
    --bsb-tl-circle-border-color: var(--bs-primary);
    --bsb-tl-indicator-color: var(--bs-white);
    --bsb-tl-circle-size: 16px;
    --bsb-tl-circle-offset: 8px;
    --bsb-tl-circle-border-size: 2px
}

.bsb-timeline-8 .timeline {
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative
}

.bsb-timeline-8 .timeline:after {
    background-color: var(--bsb-tl-color);
    bottom: 0;
    content: "";
    left: 0;
    margin-left: -1px;
    position: absolute;
    top: 0;
    width: 2px
}

@media(min-width:768px) {
    .bsb-timeline-8 .timeline:after {
        left: 33%
    }
}

.bsb-timeline-8 .timeline>.timeline-item {
    margin: 0;
    padding: 0;
    position: relative
}

.bsb-timeline-8 .timeline>.timeline-item:after {
    background: var(--bsb-tl-circle-color);
    border: var(--bsb-tl-circle-border-size) solid var(--bsb-tl-circle-border-color);
    border-radius: 50%;
    content: "";
    height: var(--bsb-tl-circle-size);
    left: calc(var(--bsb-tl-circle-offset)*-1);
    position: absolute;
    top: calc(50% - var(--bsb-tl-circle-offset));
    width: var(--bsb-tl-circle-size);
    z-index: 1
}

.bsb-timeline-8 .timeline>.timeline-item .timeline-body {
    margin: 0;
    padding: 0;
    position: relative
}

.bsb-timeline-8 .timeline>.timeline-item .timeline-meta {
    padding: 0 0 1rem 2rem
}

.bsb-timeline-8 .timeline>.timeline-item:first-child .timeline-meta {
    padding: 2rem 0 1rem 2rem
}

.bsb-timeline-8 .timeline>.timeline-item .timeline-content {
    padding: 0 0 2rem 2rem
}

@media(min-width:768px) {
    .bsb-timeline-8 .timeline>.timeline-item {
        left: 33%;
        width: 67%
    }

    .bsb-timeline-8 .timeline>.timeline-item .timeline-meta {
        display: flex;
        justify-content: flex-end;
        left: -100%;
        margin: 0;
        padding: 0 2rem 0 0;
        position: absolute;
        top: calc(50% - 10px);
        width: 100%;
        z-index: 1
    }

    .bsb-timeline-8 .timeline>.timeline-item:first-child .timeline-meta {
        padding: 0 2rem 0 0
    }

    .bsb-timeline-8 .timeline>.timeline-item .timeline-content {
        padding: 2rem
    }

    .bsb-timeline-8 .timeline>.timeline-item .timeline-indicator {
        position: relative
    }

    .bsb-timeline-8 .timeline>.timeline-item .timeline-indicator:after {
        border-width: 1px;
        border: 10px solid var(--bsb-tl-indicator-color);
        border-color: #0000 var(--bsb-tl-indicator-color) #0000 #0000;
        border-left-width: 0;
        content: "";
        left: calc(2rem - 10px);
        position: absolute;
        top: calc(50% - var(--bsb-tl-circle-offset));
        z-index: 1
    }
}
</style>

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
            <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="openmodal()" style="width: 120px;height: 50px;font-size: 20px;">
                <i class="bi bi-telephone-plus-fill" aria-hidden="true"></i> 
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

       <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-danger">
          <div class="metric-top">
            <span class="metric-label">Due Follow-ups</span>
            <span class="metric-icon"><i class="bi bi-hourglass-split" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ number_format($dueFollowUpCount) }}</div>
          {{-- <div class="metric-meta">
            <span class="text-warning">12</span>
            <span>need approval</span>
          </div> --}}
        </article>
      </div>

      {{--<div class="col-12 col-sm-6 col-xl-3">
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
                            <option value="">Select Client</option>
                            @if(!empty($clients))
                                @foreach($clients as $client)
                                    <option value="{{ $client->client_id }}">{{ $client->client_name }}-{{ $client->mob }}-{{ $client->email }}</option>
                                @endforeach
                            @endif
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

{{-- Scrolable model --}}
<div class="modal fade" id="callLogModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Call History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bsb-timeline-8">
                <ul class="timeline" id="call_log_history">
                    
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        ajax: "{{ route("view-call-log") }}",

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
            dropdownParent: $('#callTagModel')
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

    function view_call_log(client_id){
        $.ajax({
            url: "{{ route('call-history') }}",
            type: 'post',
            data: { client_id: client_id,
                    _token: '{{ csrf_token() }}'
             },
             dataType: 'json',
            success: function (data) {
                console.log(data);
                var html = ``;
                $.each(data, function (key, value) {

                    var follow_up_details = ``;
                    if(value.tag_id == 7) {
                        follow_up_details = `<span class="text-secondary fs-7">Follow-up Date: ${value.follow_up_date}</span>`;
                    }

                    html += `<li class="timeline-item">`;
                    html += `<div class="timeline-body">`;
                    html += `<div class="timeline-meta">
                                    <span>${value.call_datetime}</span>
                                </div>`;
                    html += `<div class="timeline-content timeline-indicator">
                                <h6 class="mb-1">${value.tag_name}</h6>
                                <span class="text-secondary fs-7">${value.remark}</span>
                                <br>
                               ${follow_up_details}
                            </div>`;
                    html +=  `</div>`;
                    html += `</li>`;
                });
                $('#call_log_history').html(html);
            }
        })
        $('#callLogModel').modal('show');
    }

    function tagCall(client_id) {
        $('#client').val(client_id).trigger('change');
        $("#callTagModel").modal("show");
    }
    
</script>

@endsection