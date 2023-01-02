@extends('mainpage')

@section('title','Table')


@section('content')

  <div class="row">
    <div class="panel panel-default">
     <table style="text-align: center;font-size:13" class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>1</th>
            <td>Siam</td>
            <td>Ahmed</td>
            <td>Siam007</td>
          </tr>
          <tr>
            <th>2</th>
            <td>Pias</td>
            <td>Khan</td>
            <td>Pias458</td>
          </tr>
          <tr>
            <th>3</th>
            <td>Rajib</td>
            <td>Hasan</td>
            <td>Rajib778</td>
          </tr>
          <tr>
            <th>4</th>
            <td>Jibon</td>
            <td>Hasan</td>
            <td>Jibon578</td>
          </tr>
          <tr>
            <th>5</th>
            <td>Zaman</td>
            <td>Chowdowry</td>
            <td>Zaman123</td>
          </tr>
          <tr>
            <th>6</th>
            <td>Raihan</td>
            <td>Hssain</td>
            <td>Raihan420</td>
          </tr>
        </tbody>
      </table>
    </div>
 </div>
  <!--pagination-->
  <nav aria-label="Page navigation example" style="float: right" >
    <ul class="pagination ">
     
      <li class="page-item"> <a href="#" class="page-link">Previous</a> </li>
      <li class="page-item"> <a href="#" class="page-link">1</a> </li>
      <li class="page-item"> <a href="#" class="page-link">2</a> </li>
      <li class="page-item"> <a href="#" class="page-link">3</a> </li>
      <li class="page-item"> <a href="#" class="page-link">4</a> </li>
      <li class="page-item"> <a href="#" class="page-link">5</a> </li>
      <li class="page-item"> <a href="#" class="page-link">6</a> </li>
      <li class="page-item"> <a href="#" class="page-link">Next</a> </li>
    </ul>
  
  </nav>
          
          <!--End pagination-->

@endsection

