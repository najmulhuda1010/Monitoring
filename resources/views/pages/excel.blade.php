@extends('mainpage')

@section('title','Excel')

@push('css')

<!--     <link href="{{asset('css/tableexport.css')}}" rel="stylesheet">
 -->
@endpush

@section('content')
<div class="form-group">
  <div class="input-group">
     
     
       <a href="{{route('excel.export',['type'=>'xls'])}}">
       <button type="button" class="btn btn-info" >
          <span>
            <i class="fa fa-file-excel-o"aria-hidden="true"></i> Excel
          </span>
        </button> 
      </a>
  </div>

</div>
<div class="form-group">
  <div class="input-group">
     
     
       <!-- <a href="{{route('excel.export',['type'=>'xls'])}}"> -->
       <button type="button" class="btn btn-primary" id="button" >
          <span>
            <i class="fa fa-file-excel-o"aria-hidden="true"></i> Excel
          </span>
        </button> 
     <!--  </a> -->
  </div>

</div>

<div class="form-group">
  <div class="input-group">
     
     
       <!-- <a href="{{route('excel.export',['type'=>'xls'])}}"> -->
       <button type="button" class="btn btn-primary" id="btn" >
          <span>
            <i class="fa fa-file-excel-o"aria-hidden="true"></i> Excel
          </span>
        </button> 
     <!--  </a> -->
  </div>

</div>
<div class="row">
  <h2 class="text-center">mmmmmmmmmmmmmmmmm</h2>
  <div class="table-responsive">
    <table style="text-align: center;font-size:13" class="table table-bordered">
      <tr>
        <th colspan="2"> Project Code</th>
        <th colspan="2"> Branch Code</th>
        <th colspan="2"> CO ID</th>
        <th colspan="2"> VO Code</th>
        <th colspan="2"> Member No.</th>
        <th colspan="2"> Loan Number</th>
      </tr>
      <tr>
        <th>Ref.Code</th>
        <th>ERP</th>
        <th>Ref.Code</th>
        <th>ERP</th>
        <th>Ref.Code</th>
        <th>ERP</th>
        <th>Ref.Code</th>
        <th>ERP</th>
        <th>Ref.Code</th>
        <th>ERP</th>
        <th>Ref.Code</th>
        <th>ERP</th>
      </tr>
      <tr>
          <td>015</td>
          <td>BD-0001</td>
          <td>0547</td>
          <td>BD500078</td>
          <td>150</td>
          <td>No Name</td>
          <td>2172</td>
          <td>4142</td>
          <td>000002</td>
          <td>150893</td>
          <td>151</td>
          <td>1556</td>

      </tr>


    </table>   
       
  </div><!--end responsive-->
</div><!--end row-->

@endsection



@push('scripts')
  <!-- <script src="{{asset('js/jquery.table2excel.min.js')}}"></script> -->
  <!-- <script src="{{asset('js/fileSaver.js')}}"></script>
  <script src="{{asset('js/tableexport.js')}}"></script>
 -->

  <script type="text/javascript">

  $("#button").click(function(){
  $("table").tableExport();

  });

  $("#btn").click(function(){
    $("table").table2excel({
       exclude: "",
       name: "excel",
       filename: "excel", 
    });

  });

</script>
@endpush