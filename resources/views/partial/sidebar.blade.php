<?php
	$roll=0;
	dd($roll);
	if (Session::has('roll'))
	{
		$roll = Session::get('roll');
	}
?>
 <div class="menu_section">
    <h3>Home</h3>
    <ul class="nav side-menu">
	   <?php
	    $home ='';
		if($roll =='1')
		{
			$home = 'BranchDashboard';
		}
		else if($roll =='2')
		{
			$home = 'ADashboard';
		}
		else if($roll =='3')
		{
			$home = 'RDashboard';
		}
		else if($roll =='4')
		{
			$home = 'DDashboard';
		}
		else if ((($roll=='5' or $roll=='8') or ($roll=='9' or $roll=='10')) or ($roll=='11' or $roll=='12') or $roll=='14')//else if(((($roll=='8') or ($roll=='9'))) or ((($roll=='10') or ($roll=='11')) or ($roll=='12')))
	    {
		   $home = 'NationalDashboard';
	    }
		else if($roll =='7' or ($roll=='16' or $roll=='14'))
		{
			
			$home = 'NationalDashboard';
		}
		else if($roll =='17')
		{
			$home = 'ClDashboard';
		}
		else if($roll =='18')
		{
			$home = 'ZonalDashboard';
		}
		else
		{
			?>
		  <script>
			window.location.href = 'Logout';
		  </script>
		  
		  <?php 
		}
		if($home !='')
		{
	     ?>
          <li><a href="<?php echo $home; ?>"><i class="fa fa-home"></i> Home </a></li>
		<?php 
		}
		else
		{
			?>
			  <script>
				window.location.href = 'Logout';
			  </script>
		  <?php
		}
		?>
      <!-- <li><a><i class="fa fa-edit"></i> Example <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="#">Example One</a></li>
          <li><a href="#">Example One</a></li>
        
        </ul>
      </li> -->
	  <?php
	   if($roll=='7' or ($roll=='16' or $roll=='14'))
	   {
		   ?>
		   <li><a><i class="fa fa-edit"></i> Event Creation <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
			  <li><a href="{{url('/EventCreate')}}">Monitoring Event Creation</a></li>        
			  <li><a href="{{url('/UserCreate')}}">Monitoring User Create</a></li>
			  <li><a href="{{url('/UserList')}}">Monitoring User List</a></li>        		  
			</ul>
	  </li>
	  <?php
	   }
       ?>
      <li><a><i class="fa fa-edit"></i> Reports <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
		  <?php
		   if($roll =='1')
		   {
			  ?>
			    <li><a href="{{url('/BranchDashboard')}}">Branch Dashboard</a></li>
				<li><a href="{{url('/AllPreviousView')}}">AllPreviousData View</a></li>
			  <?php
		   }
		   else if($roll =='2')
		   {
			   ?>
			     <!--<li><a href="{{url('/AreaDashboard')}}">Area Dashboard</a></li>
				 <li><a href="{{url('/AreaCurrentDashboard')}}">Current Dashboard</a></li>-->
				 <li><a href="{{url('/ADashboard')}}">Area Dashboard</a></li>
				 <li><a href="{{url('/AreaCurrentDashboard')}}">Current Dashboard</a></li>
                 <li><a href="{{url('/AreaSearch')}}">Branch wise report search</a></li>
				 <li><a href="{{url('/AreaAllPreviousView')}}">AllPreviousData View</a></li>
			   <?php 
		   }
		   else if($roll =='3')
		   {
			   ?>
			      <li><a href="{{url('/RDashboard')}}">Region Dashboard</a></li>
				  <li><a href="{{url('/RegionCurrentDashboard')}}">Current Dashboard</a></li>
                  <li><a href="{{url('/RegionSearch')}}">Branch wise report search</a></li>
				  <li><a href="{{url('/RegionAllPreviousView')}}">AllPreviousData View</a></li>
			   <?php
		   }
		   else if($roll=='4')
		   {
			   ?>
			    <li><a href="{{url('/DDashboard')}}">Division Dashboard</a></li>
			     <li><a href="{{url('/DivisionCurrentDashboard')}}">Current Dashboard</a></li>
                <li><a href="{{url('/DivisionSearch')}}">Branch wise report search</a></li>
				<li><a href="{{url('/DivisionAllPreviousView')}}">AllPreviousData View</a></li>
			   <?php
		   }
		   else if ((($roll=='5' or $roll=='8') or ($roll=='9' or $roll=='10')) or ($roll=='11' or $roll=='12'))
		   {
			   ?>
			    <li><a href="{{url('/NationalDashboard')}}">National Dashboard</a></li>
			   <!-- <li><a href="{{url('/ZonalAdd')}}">Zonal Add</a></li>
				<li><a href="{{url('/ClusterAdd')}}">Cluster Add</a></li>-->
				<li><a href="{{url('/GlobalReport')}}">Branch wise report search</a></li>
				@if($roll=='5')
				<li><a href="{{url('/NationalAllPreviousView')}}">AllPreviousData View</a></li>
				@endif
				<!--<li><a href="{{url('/Export')}}">Excel Export</a></li>-->
				<li><a href="{{url('/Ongoing')}}">Ongoing Events</a></li>
			   <!-- <li><a href="{{url('/Upcoming')}}">Upcoming Events</a></li>-->
			    <li><a href="{{url('/Closed')}}">Closed Events</a></li>
			   <?php
		   }
		   else if($roll=='7' or ($roll=='16' or $roll=='14'))
		   {
			   ?>
			    <li><a href="{{url('/NationalDashboard')}}">National Dashboard</a></li>
				<li><a href="{{url('/ManagerDashboard')}}">Manager Dashboard</a></li>
				<li><a href="{{url('/ClusterSelect')}}">Cluster Dashboard</a></li>
				<li><a href="{{url('/ZonalSelect')}}">Zonal Dashboard</a></li>
				<li><a href="{{url('/GlobalReport')}}">Branch wise report search</a></li>
				<li><a href="{{url('/NationalAllPreviousView')}}">AllPreviousData View</a></li>
				<li><a href="{{url('/Export')}}">Excel Export</a></li>
				<li><a href="{{url('/Zonal')}}">Zonal View</a></li>
				<li><a href="{{url('/Cluster')}}">Cluster View</a></li>
				<li><a href="{{url('/Ongoing')}}">Ongoing Events</a></li>
			    <li><a href="{{url('/Upcoming')}}">Upcoming Events</a></li>
			    <li><a href="{{url('/Closed')}}">Closed Events</a></li>
			   <?php
		   }
		   else if($roll=='17')
		   {
			   ?>
			   <li><a href="{{url('/ManagerDashboard')}}">Manager Dashboard</a></li>
				<li><a href="{{url('/ClDashboard')}}">Cluster Dashboard</a></li>
				<li><a href="{{url('/GlobalReport')}}">Branch wise report search</a></li>
				<li><a href="{{url('/Export')}}">Excel Export</a></li>
				<li><a href="{{url('/Cluster')}}">Cluster View</a></li>
				<li><a href="{{url('/ClusterAllPreviousView')}}">AllPreviousData View</a></li>
				<li><a href="{{url('/Ongoing')}}">Ongoing Events</a></li>
				<li><a href="{{url('/Upcoming')}}">Upcoming Events</a></li>
			    <li><a href="{{url('/Closed')}}">Closed Events</a></li>
			   <?php
		   }
		   else if($roll=='18')
		   {
			    ?>
				<li><a href="{{url('/ManagerDashboard')}}">Manager Dashboard</a></li>
				<li><a href="{{url('/ZonalDashboard')}}">Zonal Dashboard</a></li>
				<li><a href="{{url('/GlobalReport')}}">Branch wise report search</a></li>
				<li><a href="{{url('/Export')}}">Excel Export</a></li>
				<li><a href="{{url('/Zonal')}}">Zonal View</a></li>
				<li><a href="{{url('/ZonalAllPreviousView')}}">AllPreviousData View</a></li>
				<li><a href="{{url('/Ongoing')}}">Ongoing Events</a></li>
				<li><a href="{{url('/Upcoming')}}">Upcoming Events</a></li>
			    <li><a href="{{url('/Closed')}}">Closed Events</a></li>
			   <?php
		   }
		   else
		   {
			   echo "User Roll Not Found!";
		   }
		  ?>  
        
        </ul>
      </li>

      <!--<li><a href="{{url('/form')}}"><i class="fa fa-edit"></i> Form </a></li>
   
      <li><a href="{{url('/table')}}"><i class="fa fa-table"></i> Table </a> </li>

      <li><a href="{{url('/tables')}}"><i class="fa fa-table"></i> Table </a> </li>-->

   
    </ul>
</div>
              