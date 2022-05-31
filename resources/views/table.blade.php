@extends('welcome')

@section('content')

@if(session()->has('message'))
    <div class="alert alert-success mt-3">
        {{ session()->get('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{route('customerimport')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row mb-4">
        <label for="formFile" class="form-label">Import CSV File.</label>
        <div class="col-11">
            <div class="mb-3">
                <input name="file" class="form-control" type="file" id="formFile">
              </div>
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

  </form>
  <div class="row">
      <div class="col-4">
        <div class="alert alert-primary" id="totalcustomer">
          </div>
      </div>
      <div class="col-4">
        <div class="alert alert-success" id="totalmalecustomer">
        </div>
      </div>
      <div class="col-4">
        <div class="alert alert-info" id="totalfemalecustomer">
        </div>
      </div>
  </div>


  <div class="row">
    <div class="col-4">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch Id</label>
            <input type="number" class="form-control" id="branch_id" placeholder="Search by Branch Id">
        </div>
    </div>
    <div class="col-4">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" placeholder="Search by First Name">
        </div>
    </div>
    <div class="col-4">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Last  Name</label>
            <input type="text" class="form-control" id="last_name" placeholder="Search by Last Name">
        </div>
    </div>
    <div class="col-4">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Search by Email">
        </div>
    </div>
    <div class="col-4">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" placeholder="Search by phone">
        </div>
    </div>
    <div class="col-4">
        <label for="exampleFormControlInput1" class="form-label">Gender</label>
        <div class="input-group">

            <select class="form-select" id="gender" aria-label="select gender">
              <option value="" selected>Choose...</option>
              <option value="F">F</option>
              <option value="M">M</option>
            </select>
          </div>
    </div>

</div>



    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Branch Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
            </tr>
        </thead>
    </table>
@stop

@push('scripts')
<script>
$.ajax({url: "{{route('totalcustomer')}}", success: function(result){
    console.log(result);
    var total = 'Total Customer: '+result.total;
    // $("#totalcustomer").html(total);
    $('<div></div>').html(total).appendTo('#totalcustomer');
  }});

$.ajax({url: "{{route('totalmalecustomer')}}", success: function(result){
    console.log(result);
    var total = 'Total Male Customer: '+result.total;
    // $("#totalcustomer").html(total);
    $('<div></div>').html(total).appendTo('#totalmalecustomer');
  }});

$.ajax({url: "{{route('totalfemalecustomer')}}", success: function(result){
    console.log(result);
    var total = 'Total Female Customer: '+result.total;
    // $("#totalcustomer").html(total);
    $('<div></div>').html(total).appendTo('#totalfemalecustomer');
  }});

$(function() {
    var table = $('#users-table').DataTable({
           ordering: false,
           processing: false,
           serverSide: true,
           ajax: {
                    url: "{{route('alldata')}}",
                    type: 'GET',
                    data: function (d) {
                        d.branch_id = $('#branch_id').val();
                        d.first_name = $('#first_name').val();
                        d.last_name = $('#last_name').val();
                        d.email = $('#email').val();
                        d.phone = $('#phone').val();
                        d.gender = $('#gender').val();
                    }
                },
           columns: [
                    { data: 'DT_RowIndex', name: 'index' , searchable: false, orderable: false},
                    { data: 'branch_id', name: 'branch_id' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'gender', name: 'gender' },
                 ],
        });
});

$('#branch_id').keyup(function () {$('#users-table').DataTable().draw(true);});
$('#first_name').keyup(function () {$('#users-table').DataTable().draw(true);});
$('#last_name').keyup(function () {$('#users-table').DataTable().draw(true);});
$('#email').keyup(function () {$('#users-table').DataTable().draw(true);});
$('#phone').keyup(function () {$('#users-table').DataTable().draw(true);});
$('#gender').click(function () {$('#users-table').DataTable().draw(true);});
</script>
@endpush
