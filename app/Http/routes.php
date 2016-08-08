<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function() {

	Route::auth();
	Route::get('/', 'HomeController@index');
	Route::get('Forbidden', function()
	{
		return view('unauthorized');
	});

//add ACL middleware
	Route::group(['middleware' => 'hasAccess'], function() {

		#Route::get('/home', 'HomeController@index');
		Route::get('/ConnectedDevices', 'HomeController@showDevices');
		Route::get('/SyncDevice/{ip}', 'HomeController@syncDevice');
		Route::post('/UploadImage', 'HomeController@uploadImage');

		Route::get('/log', 'LogController@index');
		Route::get('/AttendenceLog/index', 'EventLogController@index');
		Route::get('/AttendenceLog/events/{employee_id}', 'EventLogController@events');

		Route::get('/Report', 'ReportController@index');
		Route::post('/Report/Generate', 'ReportController@GenerateReport');
		Route::post('/Report/Generate/Download', 'ReportController@DownloadSummary');
		Route::post('/Report/GenerateDetailed/Download', 'ReportController@DownloadDetailed');
		Route::post('/Report/GenerateDetailed', 'ReportController@GenerateDetailedReport');

		Route::get('/editPermissions' , 'ACLController@editPermissions');
		Route::get('/deletePermission/{PermissionId}' , 'ACLController@deletePermission');
		Route::post('/updatePermission' , 'ACLController@updatePermission');
		Route::post('/addPermission' , 'ACLController@addPermission');

		Route::get('/editUserPermissions' , 'ACLController@editUserPermissions');
		Route::get('/deleteUserPermission/{UserId}' , 'ACLController@deleteUserPermission');
		Route::post('/updateUserPermission' , 'ACLController@updateUserPermission');
		Route::post('/addUserPermission' , 'ACLController@addUserPermission');

		Route::post('/addUser' ,'ACLController@addUser');
		Route::post('/editUser' ,'ACLController@editUser');

		Route::get('/Calendar/view/{id}' , 'CalendarController@view');
		Route::get('/Calendar/view' , 'CalendarController@view');
		Route::post('/Calendar/deleteEvent' , 'CalendarController@deleteEvent');
		Route::post('/Calendar/updateEvent' , 'CalendarController@updateEvent');
		Route::post('/Calendar/createEvent' , 'CalendarController@createEvent');

		Route::get('/Department/index' , 'DepartmentController@index');
		Route::get('/Department/delete/{id}' , 'DepartmentController@delete');
		Route::post('/Department/create' , 'DepartmentController@create');
		Route::post('/Department/update' , 'DepartmentController@update');

		Route::get('/Leave/index' , 'LeaveController@index');
		Route::get('/Leave/delete/{id}' , 'LeaveController@delete');
		Route::post('/Leave/create' , 'LeaveController@create');
		Route::post('/Leave/update' , 'LeaveController@update');

		Route::get('/Bonus/index' , 'BonusController@index');
		Route::get('/Bonus/delete/{id}' , 'BonusController@delete');
		Route::post('/Bonus/create' , 'BonusController@create');
		Route::post('/Bonus/update' , 'BonusController@update');

		Route::get('/Abscent/index/{approve}' , 'AbscentController@index');
		Route::post('/Abscent/update' , 'AbscentController@update');

		Route::get('/Overtime/index/{approve}' , 'OvertimeController@index');
		Route::post('/Overtime/update' , 'OvertimeController@update');

		Route::get('/Shift/index' , 'ShiftController@index');
		Route::get('/Shift/assignment' , 'ShiftController@assignment');
		Route::get('/Shift/delete/{id}' , 'ShiftController@delete');
		Route::post('/Shift/create' , 'ShiftController@create');
		Route::post('/Shift/update' , 'ShiftController@update');

		Route::get('/Employee/index' , 'EmployeeController@index');
		Route::get('/Employee/delete/{id}' , 'EmployeeController@delete');
		Route::post('/Employee/create' , 'EmployeeController@create');
		Route::post('/Employee/update' , 'EmployeeController@update');
		Route::post('/Employee/enroll' , 'EmployeeController@enrollFinger');

		Route::get('/ShiftAssignment/index/{id}' , 'ShiftAssignmentController@index');
		Route::get('/ShiftAssignment/delete/{id}' , 'ShiftAssignmentController@delete');
		Route::post('/ShiftAssignment/update' , 'ShiftAssignmentController@update');

		Route::get('test' , function()
		{
			echo trans('suprema.test');
		});

	});
});

