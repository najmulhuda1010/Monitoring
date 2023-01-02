<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/table',function(){
  return view('backend.table');
});
Route::get('/demo',function(){
  return view('backend.demo');
});
Route::get('/form',function(){
  return view('backend.form');
});
Route::get('/demo1',function(){
  return view('backend.dashboardDemo');
});
Route::get('/demo2',function(){
  return view('backend.dashboardDemo2');
});
//Data Processing
 Route::get('/DataBranch','BranchControllerNew@BranchDataProcess');
 Route::get('/DataArea','AreaControllerNew@DataAreaProcess');
//End Data Processing
 Route::get('/','MainControllerNew@UserList');
//API
  Route::post('/download', 'Api@Download_data');
  Route::post('/changepassword', 'Api@changepassword');
  Route::get('/active', 'Api@active');
  Route::post('/respondent', 'Api@respondent');
  Route::get('/respondents', 'Api@respondents');
  Route::post('/survey', 'Api@survey_data');
  Route::get('/updatesince', 'Api@survey_sync');
  Route::POST('/changemonitor', 'LoginController@changemonitor');
  Route::get('/cloudmessage', 'Api@sendDataChanged');
  Route::post('/login', 'LoginController@login');
  Route::post('/login2','LoginController@server_login');
  Route::post('/uploadDatabase', 'UploadApiController@uploadDatabase');
  Route::post('/BackupData', 'MainControllerNew@BackupDataApi');//siam
  Route::get('/MandatoryCheck','MandatroyController@CheckMandatroyField');
  Route::get('/Questions','MandatroyController@Questions');

// end API
// Report //
Route::get('/weblogin', 'LoginController@templog');
Route::GET('/Ongoing2','MainControllerNew@ongoingController');
Route::GET('/test','TestController@Test');
Route::get('/EventCreate','MainControllerNew@EventCreate');
//Route::get('/Ongoing','MainControllerNew@ongoing')->name('ongoing');
Route::get('/Ongoing','ReportsController@OngoingReportView');
Route::get('/OngoingDataLoad','ReportsController@Ongoing_Reports');

Route::get('/Closed', 'ReportsController@ClosedReportView');
Route::get('/ClosedDataLoad', 'ReportsController@CloseEvents_Reports');
//Route::get('/Closed', 'MainControllerNew@ClosedEvents');

Route::get('/Upcoming', 'ReportsController@UpcomingReportView');
Route::get('/UpcomingDataLoad', 'ReportsController@UpcomingEvents_Reports');

//Route::get('/Upcoming', 'MainControllerNew@UpcomingEvents');

Route::POST('Store', 'MainControllerNew@Store');
Route::POST('Excel', 'MainControllerNew@excel_upload');
Route::get('Ongoing/edit/{id}', 'MainControllerNew@edit')->name('Ongoing.edit');
Route::PUT('ongoingUpdate/{id}', 'MainControllerNew@storeUpdate')->name('Ongoing.update');
Route::POST('dynamic_dependent', 'MainControllerNew@fetch')->name('m1dynamic.fetch');
Route::POST('dynamic_dependent2', 'MainControllerNew@m2fetch')->name('m2dynamic.fetch');
Route::delete('deleteOngoing/{id}', 'MainControllerNew@delete')->name('Ongoing.destroy');
Route::POST('UserExcel','MainControllerNew@UserExcel');
Route::get('EidtUpcoming','MainControllerNew@EditUpcoming');
Route::POST('StoreUpcoming','MainControllerNew@StoreUpcoming');
Route::delete('deleteUpcoming/{id}', 'MainControllerNew@upcomingdelete')->name('Upcoming.destroy');

Route::get('UserList', 'MainControllerNew@UserList');
Route::POST('UserSearch','MainControllerNew@User_search');
Route::get('UserCreate', 'MainControllerNew@UserView');
Route::POST('UserCreateStore', 'MainControllerNew@UserCreateStore');
Route::get('/Logout', 'MainControllerNew@Logout');
//Route::post('/delete/{id}','MainControllerNew@UserDelete');
Route::delete('/{id}/delete',['as'=>'deletecreation','uses'=>'MainControllerNew@UserDelete']);
Route::get('UserEdit','MainControllerNew@UserEdit');
Route::post('UserEditStore','MainControllerNew@UserEditStore');
//end Report //
//Data Processing
//Route::get('/BranchDataProcess','DataProcessController@BranchDataProcess');
Route::get('/BranchDataProcess','BranchControllerNew@BranchDataProcess');
//End Data Processing

//Branch Controller
Route::get('/BranchDashboard','BranchControllerNew@Branch_DashBoard');
Route::get('/AllPreviousView','BranchControllerNew@All_PreviousDataView');
Route::get('/AllPrevious','BranchControllerNew@AllPrevious');
Route::post('/Period','BranchControllerNew@Period');
//End Branch Controller

//Area Controller
 /*Route::get('/AreaDashboard','AreaController@Area_Dashboard');
 Route::get('/AreaCurrentDashboard','AreaController@Current_Dashboard');
 Route::get('Section','AreaController@sectionwisedata');*/
//End Area Controller

//Area Controller
 Route::get('/AreaDashboard','AreaControllerNew@Area_Dashboard');
 Route::get('/AreaCurrentDashboard','AreaControllerNew@Current_Dashboard');
 Route::get('Section','AreaControllerNew@sectionwisedata');
 Route::get('ADashboard','AreaControllerNew@ADashboard');
 Route::get('SectionDetails','AreaControllerNew@SectionDetails');
 Route::get('monthlySectionDetails','AreaControllerNew@monthlySectionDetails');
 Route::get('AreaSearch','AreaControllerNew@Area_Search');
 Route::get('AreaAllPreviousView','AreaControllerNew@AreaAllPreviousView');
 Route::POST('/Quarter','AreaControllerNew@quarter');
 Route::get('/AreaAllPrevious','AreaControllerNew@PreviousData');

//End Area Controller

//Region Controller
 Route::get('RDashboard','RegionControllerNew@RDashboard');
 Route::get('branchwise','RegionControllerNew@BranchWise');
 Route::get('monthlybranchwise','RegionControllerNew@monthlyBranchWise');
 Route::get('RegionSearch','RegionControllerNew@Region_Search');
 Route::POST('BranchData','RegionControllerNew@Branch');
 Route::get('RegionCurrentDashboard','RegionControllerNew@Region_CurrentDashboard');
 Route::get('AreaWiseAcheivement','RegionControllerNew@Area_Wise');
 Route::get('RegionAllPreviousView','RegionControllerNew@RegionAllPreviousView');
 Route::get('/RegionPreviousData','RegionControllerNew@RegionPreviousData');
 //End Region Controller
 
 //divisionController Controller
 Route::get('DDashboard','DivisionControllerNew@DDashboard');
 Route::get('RegionWise','DivisionControllerNew@RegionWise');
 Route::get('monthRegionWise','DivisionControllerNew@MonthWiseRegion');
 Route::get('BranchWise','DivisionControllerNew@BranchWise');
 Route::get('DivisionCurrentDashboard','DivisionControllerNew@Division_Current_Dashboard');
 Route::get('RegionWiseAcheivement','DivisionControllerNew@RegionWiseAcheivement');
 Route::get('DivisionSearch','DivisionControllerNew@Division_Search');
 Route::POST('Region','DivisionControllerNew@Region');
 Route::get('DivisionAllPreviousView','DivisionControllerNew@DivisionAllPreviousView');
 Route::get('DivisionPreviousData','DivisionControllerNew@DivisionPreviousData');
 //Route::get('branchwise','DivisionController@BranchWise');
 //End Division Controller

 // Manager Dashboard
 Route::get('ManagerDashboard','ManagerController@ManagerDashboard');
 Route::POST('RegionData','ManagerController@Region_Data');
 Route::POST('AreaData','ManagerController@Area_Data');
 Route::POST('BranchData','ManagerController@Branch_Data');
 Route::get('MSectionDetails','ManagerController@SectionDetails');
 Route::get('Remarks','ManagerController@Remarks');
 
 //End Manager Dashboard
//National Dashboard
 Route::get('NationalDashboard','NationalController@NationalView');
 Route::get('DivisionWiseAc','NationalController@DivisionWise');
 Route::get('AreaWise','NationalController@AreaWise');
 Route::get('NationalSectionDetails','NationalController@NationalSectionDetails');
 Route::get('monthDivisionWise','NationalController@MonthDivisionWise');
 Route::get('MonthAreaWise','NationalController@MonthAreaWise');
 Route::get('GlobalReport','NationalController@GlobalReport');
 Route::get('ZonalAdd','NationalController@Zonal_Add');
 Route::get('ZonalAddAccId','NationalController@Zonal_Asc_Id_Add');//siam
 Route::post('ZonalAdd','NationalController@Zonal_Store');
 Route::post('ZonalAddAccId','NationalController@Zonal_Asc_Id_Store');//siam
 Route::get('ClusterAdd','NationalController@Cluster_Add');
 Route::get('ClusterAddAccId','NationalController@Cluster_Asc_Id_Add');//siam
 Route::post('ClusterAdd','NationalController@Cluster_Store');
 Route::post('ClusterAddAccId','NationalController@Cluster_Asc_Id_Store');//siam
 Route::get('ClusterSelect','NationalController@ClusterDash');
 Route::post('ClusterData','NationalController@GetCluster');
 Route::get('ZonalSelect','NationalController@ZonalDash');
 Route::get('Cluster','NationalController@ClusterView');
 Route::get('ClusterLoad','NationalController@ClusterViewLoad');
 Route::get('Zonal','NationalController@ZonalView');
 Route::POST('ClusterViewSearch','NationalController@ClusterViewSearch');
 Route::get('NationalAllPreviousView','NationalController@NationalAllPreviousView');
 Route::get('NationalPreviousData','NationalController@NationalPreviousData');
 //End National
  // Cluster Dashboard
 Route::get('DataLoad','ClusterController@DataInsert');
 Route::get('ClDashboard','ClusterController@ClusterView');
 Route::get('ClusterSearch','ClusterController@Cluster_Search');
 Route::POST('Division','ClusterController@Division_Search');
 Route::get('ClusterAllPreviousView','ClusterController@All_PreviousDataView');//siam
 Route::get('ClusterAllPreviousData','ClusterController@AllPrevious');//siam
 // End Cluster
 //Zonal Dashboard
  Route::get('ZDataLoad','ZonalController@ZDataInsert');
  Route::get('ZonalDashboard','ZonalController@ZonalDashboard');
  Route::get('ZonalAllPreviousView','ZonalController@All_PreviousDataView');//siam
  Route::get('ZonalAllPreviousData','ZonalController@AllPrevious');//siam
 //End Zonal Dashboard
//Export Controller
 Route::get('Export','ExportController@Export');
 Route::post('quarter','ExportController@quarter');
 Route::post('period','ExportController@period');
//End Export Controller
//Area Dashboard Controller
 Route::get('/AmdashboardValues','AreaDashboardController@BranchValues');
 //Extra Route
 Route::get('SurveyExcel','MainControllerNew@Survey_Excel');//siam
 Route::post('SurveyExcelStore','MainControllerNew@excel_surveydata_upload');//siam
 Route::post('excel_addressdata_upload','MainControllerNew@excel_addressdata_upload');//siam brac offices address excelsheet upload
 Route::get('UploadJson','MainControllerNew@Upload_json');
 Route::post('BackupJsonStore','MainControllerNew@BackupJsonStore');
 //End Extra
