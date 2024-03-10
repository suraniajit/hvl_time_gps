<div class="modal fade bd-example-modal-xl relaince_service_report_model" tabindex="1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <img src="{{asset('img/hvl-logo.png')}}" class="img-responsive" height="50" width="100" alt="">
            <h4 style="padding-left:19px;padding-top:15px;">Relaince Service Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4> 
                <center>
                    Certification by Store Manager for Fresh /SB/Super / Hyper 
                </center>
            </h4>
            <div class="modal-body">
                <form id="relaince_service_form" name="relaince_service_form" enctype="multipart/form-data">
                    @csrf 
                    <input type="hidden" id="acivity_id" name="activity_id" value="">
                    <div class="row">
                        <div class="form-group col-sm-3 col-md-3">
                            <lable>Store Name:- </lable>
                            <input type="text"   name="store_name" id="store_name"  class="form-control rel_form">
                        </div>
                        <div class="form-group col-sm-3 col-md-3">
                            <lable>Store code:- </lable>
                            <input type="text"   name="store_code" id="store_code" class="form-control rel_form">
                        </div>
                        <div class="form-group col-sm-3 col-md-3">
                            <lable>Format:- </lable>
                            <input type="text"   name="forment" id="forment" class="form-control rel_form">
                        </div>
                        <div class="form-group col-sm-3 col-md-3">
                            <lable>State:- </lable>
                            <input type="text"   name="state" id="state"  class="form-control rel_form">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <lable>Carpet Area:- </lable>
                            <input type="text"   name="carpet_area" id="carpet_area"  class="form-control rel_form">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <h5>Certification for the Pest Control works and backup calculations for the invoice to be raised by the Contractor</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4 col-md-4">
                            <lable>Vendor name:- </lable>
                            <input type="text" name="vendor_name" id="vendor_name" class="form-control rel_form1" value="HVL PEST SERVICES PVT LTD"  readonly="" >
                        </div>
                        <div class="form-group col-sm-4 col-md-4">
                            <lable>Month:- </lable>
                            <select id="month"  class="form-control rel_form">
                                @foreach($months as $key=>$month)
                                    <option value="{{$key}}">{{$month}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4 col-md-4 rel_form">
                            <lable>Year:- </lable>
                            <select id="year"  class="form-control">
                                @for($i=2000;$i <= date('Y');$i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <table border="1">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Activity</th>
                            <th>Date of Services</th>
                            <th>Amount payable as per Contract</th>
                            <th>Recommended Deductions</th>
                            <th>Recommended payments as per Store Manager's certification</th>
                            <th>Remarks</th>
                        </tr>
                        @foreach($first_form_activity_list as $key=>$row)
                        <tr>
                            <td>{{$key+1}}</td>
                            <th>
                                {{$row}}
                                <input type="hidden" data-id="activity" value="{{$row}}"  class="form-control activity_first_element first_element rel_form">
                            </th>
                            <td> 
                                <input type="text"   name="first[date_of_service][]" data-id="date_of_service" autocomplete="off" class="form-control datepicker date_of_service_first_element first_element rel_form">
                            </td>
                            <td> 
                                <input type="text"   name="first[payable_amount][]" data-id="payable_amount"  class="form-control payable_amount_first_element first_element rel_form">
                            </td>
                            <td> 
                                <input type="text"   name="first[recommended_deductions][]" data-id="recommended_deductions"  class="form-control recommended_deductions_first_element rel_form first_element ">
                            </td>
                            <td> 
                                <input type="text"   name="first[recommended_payments][]" data-id="recommended_payments"  class="form-control recommended_payments_first_element first_element rel_form">
                            </td>
                            <td> 
                                <input type="text"   name="first[remarks][]" data-id="remarks"  class="form-control remarks_first_element first_element rel_form">
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>{{$key+1}}</td>
                            <th colspan="2" >Total</th>
                            <td> 
                                <input type="text"   name="first[payable_amount][]"  class="form-control rel_form">
                            </td>
                            <td> 
                                <input type="text"   name="first[recommended_deductions][]"  class="form-control rel_form recommended_deductions">
                            </td>
                            <td> 
                                <input type="text"   name="first[recommended_payments][]"  class="form-control rel_form recommended_payments">
                            </td>
                            <td> 
                                <input type="text"   name="first[remarks][]"  class="form-control remarks rel_form">
                            </td>
                        </tr>
                    </table>
                    <br>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <h5> 
                                RM: Rodent Management (Weekly), FM : Fly Management (Weekly), CM: Cockroach Management (Monthly)
                            </h5>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <h5> 
                                Details of activities in a month (Only for analysis and for future corrections and not for deductions)
                            </h5>
                        </div>
                    </div>
                    <table border="1">
                        <tr>
                            <th>No.</th>
                            <th>Details of activity</th>
                            <th>Week 1</th>
                            <th>Week 2</th>
                            <th>Week 3</th>
                            <th>Week 4</th>
                            <th>Total</th>
                            <th>Remark</th>
                        </tr>
                        @foreach($relaince_form_activity_details as $key=>$row)
                        <tr>
                            <td>{{chr(97+$key)}}</td>
                            <th>
                                {{$row}}
                                <input type="hidden" data-id="detail_of_activity" value="{{$row}}"  class="form-control rel_form detail_of_activity_second_element second_element">
                            </th>
                            <td> 
                                <input type="text" data-id="week_1" class="form-control week_1_second_element second_element rel_form">
                            </td>
                            <td> 
                                <input type="text" data-id="week_2" class="form-control week_2_second_element second_element rel_form">
                            </td>
                            <td> 
                                <input type="text" data-id="week_3" class="form-control week_3_second_element second_element rel_form">
                            </td>
                            <td> 
                                <input type="text" data-id="week_4" class="form-control week_4_second_element second_element rel_form">
                            </td>
                            <td> 
                                <input type="text" data-id="total" class="form-control total_second_element second_element rel_form">
                            </td>
                            <td> 
                                <input type="text" data-id="remarks" class="form-control remarks_second_element second_element rel_form">
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <br>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <h5> General observations</h5>
                        </div>
                    </div>
                    <table border="1">
                        <tr>
                            <th>a</th>
                            <th>Last Store audit carried by PC Contractor</th>
                            <td> 
                                <input type="text" data-id="last_observations_date" id="last_observations_date" autocomplete="off" class="form-control datepicker rel_form ">
                            </td>
                        </tr>
                        <tr>
                            <th>b</th>
                            <th>Structural repair works suggested by PC Contractor during last audit</th>
                            <td colspan="6"> 
                                <input type="text" data-id="last_audit_suggestional" id="last_audit_suggestional"  class="form-control rel_form">
                            </td>
                        </tr>
                        <tr>
                            <th>c</th>
                            <th>Structural repair work completed as recommended  by PC Contractor during earlier audit </th>
                            <td colspan="6"> 
                                <input type="text" data-id="earlier_audit_recommended" id="earlier_audit_recommended" class="form-control rel_form">
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table border="1">
                        <tr>
                            <th>9</th>
                            <th>Pest Control Service</th>
                            <th>Frequency</th>
                            <th>Date of service</th>
                            <th>Chemical used/ Glue pad changed</th>
                            <th>Dilution</th>
                            <th>Application Method</th>
                            <th>Pest Control Operator (PCO) Sign</th>
                            <th>Remarks</th>
                        </tr>
                        @foreach($pest_controller_service as $pest_service_key=>$services)
                        <tr>
                            <td>{{chr($pest_service_key)}}</td>
                            <td>
                                {{$services}}
                                <input type="hidden" data-id="pest_control_service" class="pest_control_service_fourth_element fourth_element rel_form" value="{{$services}}">
                            </td>
                            <td>
                                <select data-id="frequency" class="form-control frequency_fourth_element fourth_element rel_form">
                                <option value=""></option>
                                @foreach($frequency_option as $key => $option)
                                    <option value="{{$key}}">{{$option}}</option>
                                @endforeach    
                                </select>
                            </td>
                            <td>
                                <input type="text"   data-id="date_of_service" autocomplete="off" class="form-control rel_form date_of_service_fourth_element fourth_element datepicker">
                            </td>
                            <td>
                                <input type="text"   data-id="service_type"  class="form-control service_type_fourth_element rel_form fourth_element">
                            </td>
                            <td>
                                <input type="text"   data-id="dilution"  class="form-control dilution_fourth_element fourth_element rel_form">
                            </td>
                            <td>
                                <input type="text"   data-id="application_method"  class="form-control application_method_fourth_element rel_form fourth_element">
                            </td>
                            <td>
                                <img src="" class="pco_sign_image_fourth_element image_display" id="image_pco_{{$pest_service_key}}"  style="display:none" width="100">
                                <input type="hidden"   id="image_file_pco_{{$pest_service_key}}" data-id="pco_sign"  class="pco_sign_fourth_element rel_form fourth_element" value="">
                                <a href='javascript:;' id="pco_{{$pest_service_key}}" class="pco_sign_image_button siganature_click_button" data-toggle="modal" data-target="#SignatureModal"> Take New Signature</a>                           
                            </td>
                            <td>
                                <input type="text"   data-id="remark"  class="form-control remark_fourth_element fourth_element rel_form">
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <br>

                    <table border="1">
                        <tr>
                            <th>Vendor Representative Name :</th>
                            <th>Employee :</th>
                            <th>Mobile</th>
                            <th>Week</th>
                            <th>Sign & Stamp</th>
                            <th>Store Manager Name</th>
                            <th>Week</th>
                            <th>Sign & Stamp</th>
                        </tr>
                        @foreach($month_week_list as $key=>$week_row)
                        <tr>
                            <td>
                                <input type="text" data-id="vender_name"  class="form-control  vender_name_fifth_element fifth_element rel_form">
                            </td>
                            <td>
                                <input type="text" data-id="employee_name"  class="form-control  employee_name_fifth_element fifth_element rel_form">
                            </td>
                            <td>
                                <input type="text" data-id="mobile"  class="form-control  mobile_fifth_element fifth_element rel_form">
                            </td>
                            <th>
                                {{$week_row}}
                                <input type="hidden" data-id="week"  value="{{$week_row}}" class="form-control week_fifth_element fifth_element rel_form">
                            </th>
                            <td>
                                <img src="" style="display:none" id="image_vender_{{$key}}" class="vender_sign_image_fifth_element image_display" width="100">
                                <input type="hidden" id="image_file_vender_{{$key}}" data-id="vender_sign" class="vender_sign_fifth_element rel_form fifth_element" value="">
                                <a href='javascript:;' id="vender_{{$key}}" class="vender_sign_image_button siganature_click_button" data-toggle="modal" data-target="#SignatureModal"> Take New Signature</a>
                            </td>
                            
                            <td>
                                <input type="text" data-id="store_manager_name" class="form-control rel_form store_manager_name_fifth_element fifth_element">
                            </td>
                            <th>{{$week_row}}</th>
                            <td>
                                <img src=""  style="display:none" id="image_store_manager_{{$key}}" class="store_manager_sign_image_fifth_element image_display"  width="100">
                                <input type="hidden" id="image_file_store_manager_{{$key}}" data-id="store_manager_sign" class="store_manager_sign_fifth_element rel_form fifth_element" value="">
                                <a href='javascript:;' id="store_manager_{{$key}}" class="store_manager_sign_image_button  siganature_click_button" data-toggle="modal" data-target="#SignatureModal"> Take New Signature</a>
                           </td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <a class="btn btn-success rounded submit_relaince_service_form" data-dismiss="modal"  data-action="save-jpg">Submit</a>
                        </div>
                    </div>
                </form>
            </div>
             <div class="info note_div">
                <p><strong>Note :</strong> Its computer generated service report no need seal</p>
            </div>
        </div>
    </div>
</div>
<input type="hidden"  id="relaince_form_signature_element" value="">
                                