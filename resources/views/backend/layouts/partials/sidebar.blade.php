<?php
	$roll=0;
	if (Session::has('roll'))
	{
		$roll = Session::get('roll');
	}
?>
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
  <!--begin::Brand-->
  <div class="brand flex-column-auto" id="kt_brand">
    <!--begin::Logo-->
    <a href="https://trendx.brac.net/auth" class="brand-logo">
      <h3 id="main_logo_brac" style="color: #FB3199;margin-top: 8px;">Brac Microfinance</h3>
      <!-- <img alt="Logo" src="media/logos/logo-light.png" /> -->
    </a>
    <!--end::Logo-->
    <!--begin::Toggle-->
    <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
      <span class="svg-icon svg-icon svg-icon-xl">
        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Angle-double-left.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <polygon points="0 0 24 0 24 24 0 24" />
            <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
            <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
          </g>
        </svg>
        <!--end::Svg Icon-->
      </span>
    </button>
    <!--end::Toolbar-->
  </div>
  <!--end::Brand-->
  <!--begin::Aside Menu-->
  <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
      <!--begin::Menu Nav-->
      <ul class="menu-nav">
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
		else if ((($roll=='5' or $roll=='8') or ($roll=='9' or $roll=='10')) or ($roll=='11' or $roll=='12'))//else if(((($roll=='8') or ($roll=='9'))) or ((($roll=='10') or ($roll=='11')) or ($roll=='12')))
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
          <li class="menu-item {{ (request()->is('BranchDashboard') || 
            request()->is('ADashboard') ||
            request()->is('RegionSearch')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          {{-- <li class="menu-item {{ ($home) ? 'menu-item-active' : '' }}" aria-haspopup="true"> --}}
            <a href="<?php echo $home; ?>" class="menu-link">
              <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-09-15-014444/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"/>
                  <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000"/>
                </g>
              </svg><!--end::Svg Icon--></span>
              <span class="menu-text">Home</span>
            </a>
          </li>
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
        <?php
        if($roll=='7' or ($roll=='16' or $roll=='14'))
        {
          ?>
          <li class="menu-section">
            <h4 class="menu-text" style="color: #adadad">Events</h4>
            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
          </li>
          <li class="menu-item menu-item-submenu {{ (
            request()->is('EventCreate') || 
            request()->is('UserCreate') ||
            request()->is('UserList')  ) ? 'menu-item-open menu-item-here' : ''}}" aria-haspopup="true" data-menu-toggle="hover">
            <a href="javascript:;" class="menu-link menu-toggle">
              <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-09-15-014444/theme/html/demo1/dist/../src/media/svg/icons/Media/Playlist2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"/>
                  <path d="M11.5,5 L18.5,5 C19.3284271,5 20,5.67157288 20,6.5 C20,7.32842712 19.3284271,8 18.5,8 L11.5,8 C10.6715729,8 10,7.32842712 10,6.5 C10,5.67157288 10.6715729,5 11.5,5 Z M5.5,17 L18.5,17 C19.3284271,17 20,17.6715729 20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 C4,17.6715729 4.67157288,17 5.5,17 Z M5.5,11 L18.5,11 C19.3284271,11 20,11.6715729 20,12.5 C20,13.3284271 19.3284271,14 18.5,14 L5.5,14 C4.67157288,14 4,13.3284271 4,12.5 C4,11.6715729 4.67157288,11 5.5,11 Z" fill="#000000" opacity="0.3"/>
                  <path d="M4.82866499,9.40751652 L7.70335558,6.90006821 C7.91145727,6.71855155 7.9330087,6.40270347 7.75149204,6.19460178 C7.73690043,6.17787308 7.72121098,6.16213467 7.70452782,6.14749103 L4.82983723,3.6242308 C4.62230202,3.44206673 4.30638833,3.4626341 4.12422426,3.67016931 C4.04415337,3.76139218 4,3.87862714 4,4.00000654 L4,9.03071508 C4,9.30685745 4.22385763,9.53071508 4.5,9.53071508 C4.62084305,9.53071508 4.73759731,9.48695028 4.82866499,9.40751652 Z" fill="#000000"/>
                </g>
              </svg><!--end::Svg Icon--></span>
              <span class="menu-text">Events</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
              <i class="menu-arrow"></i>
              <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                  <span class="menu-link">
                    <span class="menu-text">Events</span>
                  </span>
                </li>
                <li class="menu-item {{ (request()->is('EventCreate')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                  <a href="{{url('/EventCreate')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">Monitoring Event Create</span>
                  </a>
                </li>
                <li class="menu-item {{ (request()->is('UserCreate')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                  <a href="{{url('/UserCreate')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">Monitoring User Create</span>
                  </a>
                </li>
                <li class="menu-item {{ (request()->is('UserList')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                  <a href="{{url('/UserList')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">Monitoring User List</span>
                  </a>
                </li>
                
              </ul>
            </div>
          </li>
       <?php
        }
          ?>
        
        <li class="menu-section">
          <h4 class="menu-text" style="color: #adadad">Reports</h4>
          <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
        </li>
        <li class="menu-item menu-item-submenu 
        {{ (
        request()->is('BranchDashboard') || 
        request()->is('AllPreviousView') || 
        request()->is('ADashboard')|| 
        request()->is('AreaSearch')|| 
        request()->is('AreaAllPreviousView')|| 
        request()->is('RDashboard')|| 
        request()->is('RegionSearch')|| 
        request()->is('RegionAllPreviousView')|| 
        request()->is('DDashboard')|| 
        request()->is('DivisionSearch')|| 
        request()->is('DivisionAllPreviousView')|| 
        request()->is('NationalDashboard')|| 
        request()->is('GlobalReport')|| 
        request()->is('Ongoing')|| 
        request()->is('Closed')|| 
        request()->is('ManagerDashboard')|| 
        request()->is('ClusterSelect')|| 
        request()->is('ZonalSelect')|| 
        request()->is('Export')|| 
        request()->is('Zonal')|| 
        request()->is('Cluster')|| 
        request()->is('NationalAllPreviousView')|| 
        request()->is('ClDashboard')|| 
        request()->is('ZonalDashboard')|| 
        request()->is('ClusterAllPreviousView')|| 
        request()->is('ZonalAllPreviousView')|| 
        request()->is('Upcoming')) ? 'menu-item-open menu-item-here' : ''}}" aria-haspopup="true" data-menu-toggle="hover">
          <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"/>
                  <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
                  <path d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                </g>
              </svg><!--end::Svg Icon--></span>
            <span class="menu-text">Reports</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
              <li class="menu-item menu-item-parent" aria-haspopup="true">
                <span class="menu-link">
                  <span class="menu-text">Reports</span>
                </span>
              </li>
              <?php
		   if($roll =='1')
		   {
        ?>
        <li class="menu-item {{ (request()->is('BranchDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/BranchDashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Branch Dashboard</span>
          </a>
        </li>
        <li class="menu-item {{ (request()->is('AllPreviousView')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/AllPreviousView')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">All Previous Data View</span>
          </a>
        </li>
			  <?php
		   }
		   else if($roll =='2')
		   {
         ?>
         <li class="menu-item {{ (request()->is('ADashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/ADashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Area Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('AreaSearch')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/AreaSearch')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Branch wise report search</span>
          </a>
        </li><li class="menu-item {{ (request()->is('AreaAllPreviousView')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/AreaAllPreviousView')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">All Previous Data View</span>
          </a>
        </li>
			   <?php 
		   }
		   else if($roll =='3')
		   {
         ?>
         <li class="menu-item {{ (request()->is('RDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/RDashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Region Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('RegionSearch')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/RegionSearch')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Branch wise report search</span>
          </a>
        </li><li class="menu-item {{ (request()->is('RegionAllPreviousView')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/RegionAllPreviousView')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">All Previous Data View</span>
          </a>
        </li>
			   <?php
		   }
		   else if($roll=='4')
		   {
         ?>
         <li class="menu-item {{ (request()->is('DDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/DDashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Division Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('DivisionSearch')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/DivisionSearch')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Branch wise report search</span>
          </a>
        </li><li class="menu-item {{ (request()->is('DivisionAllPreviousView')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/DivisionAllPreviousView')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">All Previous Data View</span>
          </a>
        </li>
			    <?php
		   }
		   else if ((($roll=='5' or $roll=='8') or ($roll=='9' or $roll=='10')) or ($roll=='11' or $roll=='12'))
		   {
         ?>
         <li class="menu-item {{ (request()->is('NationalDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/NationalDashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">National Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('GlobalReport')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/GlobalReport')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Branch wise report search</span>
          </a>
        </li>
        @if($roll=='5')
				<li class="menu-item {{ (request()->is('NationalAllPreviousView')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/NationalAllPreviousView')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">All Previous Data View</span>
          </a>
        </li>
				@endif
        <li class="menu-item {{ (request()->is('Ongoing')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Ongoing')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Ongoing Events</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Closed')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Closed')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Closed Events</span>
          </a>
        </li>
			    <?php
		   }
		   else if($roll=='7' or ($roll=='16' or $roll=='14'))
		   {
         ?>
         <li class="menu-item {{ (request()->is('NationalDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/NationalDashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">National Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('ManagerDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/ManagerDashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Manager Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('ClusterSelect') || request()->is('ClDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/ClusterSelect')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Cluster Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('ZonalSelect') || request()->is('ZonalDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/ZonalSelect')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Zonal Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('GlobalReport')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/GlobalReport')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Branch wise report search</span>
          </a>
        </li><li class="menu-item {{ (request()->is('NationalAllPreviousView')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/NationalAllPreviousView')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">All Previous Data View</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Export')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Export')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Excel Export</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Zonal')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Zonal')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Zonal View</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Cluster')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Cluster')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Cluster View</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Ongoing')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Ongoing')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Ongoing Events</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Upcoming')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Upcoming')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Upcoming Events</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Closed')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Closed')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Closed Events</span>
          </a>
        </li>
			    <?php
		   }
		   else if($roll=='17')
		   {
         ?>
         <li class="menu-item {{ (request()->is('ManagerDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/ManagerDashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Manager Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('ClDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/ClDashboard')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Cluster Dashboard</span>
          </a>
        </li><li class="menu-item {{ (request()->is('GlobalReport')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/GlobalReport')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Branch wise report search</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Export')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Export')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Excel Export</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Cluster')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Cluster')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Cluster View</span>
          </a>
        </li><li class="menu-item {{ (request()->is('ClusterAllPreviousView')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/ClusterAllPreviousView')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">All Previous Data View</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Ongoing')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Ongoing')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Ongoing Events</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Upcoming')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Upcoming')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Upcoming Events</span>
          </a>
        </li><li class="menu-item {{ (request()->is('Closed')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
          <a href="{{url('/Closed')}}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
              <span></span>
            </i>
            <span class="menu-text">Closed Events</span>
          </a>
        </li>
        <?php
		   }
		   else if($roll=='18')
		   {
          ?>
          <li class="menu-item {{ (request()->is('ManagerDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/ManagerDashboard')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Manager Dashboard</span>
            </a>
          </li><li class="menu-item {{ (request()->is('ZonalDashboard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/ZonalDashboard')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Zonal Dashboard</span>
            </a>
          </li><li class="menu-item {{ (request()->is('GlobalReport')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/GlobalReport')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Branch wise report search</span>
            </a>
          </li><li class="menu-item {{ (request()->is('Export')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/Export')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Excel Export</span>
            </a>
          </li><li class="menu-item {{ (request()->is('Zonal')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/Zonal')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Zonal View</span>
            </a>
          </li><li class="menu-item {{ (request()->is('ZonalAllPreviousView')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/ZonalAllPreviousView')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">All Previous Data View</span>
            </a>
          </li><li class="menu-item {{ (request()->is('Ongoing')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/Ongoing')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Ongoing Events</span>
            </a>
          </li><li class="menu-item {{ (request()->is('Upcoming')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/Upcoming')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Upcoming Events</span>
            </a>
          </li><li class="menu-item {{ (request()->is('Closed')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
            <a href="{{url('/Closed')}}" class="menu-link">
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Closed Events</span>
            </a>
          </li>
				<?php
		   }
		   else
		   {
			   echo "User Roll Not Found!";
		   }
		  ?>
            </ul>
          </div>
        </li>
        
        </li>
      </ul>
      <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
  </div>
  <!--end::Aside Menu-->
</div>