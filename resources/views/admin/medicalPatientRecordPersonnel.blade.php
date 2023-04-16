@extends('')

@section('content')


<style>
    ::-webkit-input-placeholder {
   font-style: italic;
    }
    :-moz-placeholder {
    font-style: italic;  
    }
    ::-moz-placeholder {
    font-style: italic;  
    }
    :-ms-input-placeholder {  
    font-style: italic; 
    }

    body{
        background-image: url({{ asset('media/RegistrationBG.jpg') }});
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    div.settings {
    display:grid;
    grid-template-columns: max-content max-content;
    grid-gap:5px;
    padding-left: -5px;
    }
    div.settings label{
        text-align:right;
    }
    span.h5{
        margin-bottom:10px;
    }
    .checkboxes input, select{
        outline: 1px solid #d4d4d4dc;
    }
    option.alternate{
        background-color: #ececec;
    }
    .custom-file-upload {
        padding: 6px 12px;
        cursor: pointer;
    }

    input.signa{
        display: inline-block;
        width: 6em;
        position: relative;
        top: -3em;
        margin-bottom: 10px;
    }

    label.signa{
        display: inline-block;
        width: 6em;
        margin-top: 50px;
        margin-right: .5em;
    }
    .no-gutters {
        margin-right: 0;
        margin-left: 0;

        > .col,
        > [class*="col-"] {
            padding-right: 0;
            padding-left: 0;
        }
    }
    .ui-state-default:hover{
        background-color: #009edf !important;
    }
    .form-floating>.form-control,
    .form-floating>.form-control-plaintext {
      padding: 0rem 0.75rem;
    }
    .form-floating>.form-control,
    .form-floating>.form-control-plaintext,
    .form-floating>.form-select {
      height: calc(2.5rem + 2px);
      line-height: 1rem;
    }
    .form-floating>label {
      padding: 0.5rem 2.5rem;
    }
    @media (min-width: 1200px) {
    .container{
        max-width: 1500px;
    }
}
</style>
<!-- Header -->
<div class="container-lg w-20 position-relative my-2 bg-light text-dark pt-5 px-3 headMargin checkboxes">
    @if($patient->hasValidatedRecord)
    <!-- HAS VALIDATED MEDICAL RECORD -->
    <i class="bi bi-person-check icon position-absolute top-0 end-0 fs-2" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Validated Medical Record"></i>
  @else
    <!-- HAS MEDICAL RECORD BUT NOT VALIDATED -->
    <i class="bi bi-file-earmark-medical icon position-absolute top-0 end-0 fs-2" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Medical Record not Validated"></i>
  @endif
    <div class="d-flex flex-row">
        <div class="col-6 border border-dark border-end-0 d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('media/BU-logo.png') }}" class="rounded" alt="BUHS-LOGO" style="width:100%; margin-left: 30%;">
                  </div>                  
                <div class="col-sm">
                    <header class="text-center px-auto py-auto">
                        <h5 class="display-7 pt-3 fs-3 font-monospace">
                            Republic of the Philippines<br>
                        </h5>
                        <h6 class="fw-bold fs-5 font-monospace">Bicol University</h6>
                        <h6 class="fs-5 font-monospace">Bicol University Health Services</h6>
                    </header>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('media/BUHS-logo.png') }}" class="rounded float-end" alt="BUHS-LOGO" style="width:100%; margin-right: 30%;">
                </div>
            </div>
        </div>
        <div class="col-6 border border-dark d-flex align-items-center justify-content-center">
            <header class="text-center px-auto py-auto">
              <h2 class="display-7 fs-3 pt-auto font-monospace">Personnel Health Record</h2>
            </header>
        </div>          
    </div>

    <!--Personal Basic Information-->

    @if(session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
    @endif
    @if(session('alreadySubmitted'))
    <div class="alert alert-danger">
        {{ session('alreadySubmitted') }}
    </div>
    @endif


<form method="POST" action="{{ route('medicalForm.store') }}" id="MRP_form" enctype="multipart/form-data" class="row g-3 pt-5 px-4">
    @csrf

        <div class="row row-cols-lg-4 row-cols-md-2 mt-2">
            <div class="col-xl-4 col-lg-12">
                <label for="designation" class="form-label h6">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" value="{{  }}" readonly>               
            </div>
            <div class="col-xl-4 col-lg-12">
                <p class="h6">Unit/Department</p>
                <input type="text" class="form-control" id="unitDepartment" name="unitDepartment" value="{{  }}" readonly>
            </div> 
            <div class="col-xl-4 col-lg-12">
                <p class="h6">Campus</p>
                <input type="text" class="form-control" id="P_campusSelect" name="P_campusSelect" value="{{  }}" readonly>
            </div>   
        </div>   
    <div class="d-flex flex-row">
        <h4 class="pb-3"></h4>
    </div>   
        <div class="col-md-2">
            <label for="MRP_lastName" class="form-label h6">Last Name</label>
            <input type="text" class="form-control" id="MRP_lastName" name="MRP_lastName" value="{{  }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_firstName" class="form-label h6">First Name</label>
            <input type="text" class="form-control" id="MRP_firstName" name="MRP_firstName" value="{{  }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_middleName" class="form-label h6">Middle Name</label>
            <input type="text" class="form-control" id="MRP_middleName" name="MRP_middleName" value="{{  }}" readonly>
        </div>
        <div class="col-md-1">
            <label for="MRP_age" class="form-label h6">Age</label>
            <input type="text" class="form-control" id="MRP_age" name="MRP_age" value="{{  }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_sex" class="form-label h6">Sex</label>
            <input type="text" class="form-control" id="MRP_sex" name="MRP_sex" value="{{  }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_gender" class="form-label h6">Gender</label>
            <input type="text" class="form-control" id="MRP_gender" name="MRP_gender" value="{{  }}" readonly>
        </div>
        <div class="col-md-1">
            <div class="form-group d-flex align-items-center pt-4" style="margin-top: 6px;">
                <input class="form-check-input" type="checkbox" name="MRP_pwd" id="MRP_pwd" {{  }} onclick="this.checked=!this.checked;"/>
                <label for="MRP_pwd" class="form-check-label mt-1 ms-1">PWD</label>
              </div>
        </div>
        <div class="col-md-2">
            <label for="MRP_placeOfBirth" class="form-label h6">Date of Birth</label>
            <input type="text" class="form-control" id="MRP_placeOfBirth" name="MRP_placeOfBirth" value="{{  }}" readonly>
        </div>

        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        
        <script>
        $(document).ready(function() {
            $("#MRP_placeOfBirth").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'MM/d/yy',
                showButtonPanel: true,
                yearRange: "1900:c",
                showAnim: 'slideDown',
            });
        });
        </script>

        <div class="col-md-4">
            <label for="MRP_placeOfBirth" class="form-label h6">Place of Birth</label>
            <input type="text" class="form-control" id="MRP_placeOfBirth" name="MRP_placeOfBirth" value="{{  }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_civilStatus" class="form-label h6">Civil Status</label>
            <input type="text" class="form-control" id="MRP_civilStatus" name="MRP_civilStatus" value="{{  }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_nationality" class="form-label h6">Nationality</label>
            <input type="text" class="form-control" id="MRP_nationality" name="MRP_nationality" value="{{  }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_religion" class="form-label h6">Religion</label>
            <input type="text" class="form-control" id="MRP_religion" name="MRP_religion" value="{{  }}" readonly>
        </div>
        <div class="col-md-10">
            <label for="MRP_address" class="form-label h6">Home Address</label>
            <input type="text" class="form-control" id="MRP_address" name="MRP_address" value="{{  }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_personnelContactNumber" class="form-label h6">Contact No.</label>
            <input type="text" class="form-control" placeholder="09123456789" id="MRP_personnelContactNumber" name="MR_personnelContactNumber" value="{{  }}" readonly>
        </div>
        <h5 class="pt-2">Contact Person in case of Emergency:</h5>
        <div class="col-md-6">
            <label for="MRP_contactName" class="form-label h6">Name</label>
            <input type="text" class="form-control" id="MRP_contactName" name="MRP_contactName" value="{{  }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MRP_ContactNumber" class="form-label h6">Contact No.</label>
            <input type="text" class="form-control" id="MRP_ContactNumber" name="MR_ContactNumber" value="{{  }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MRP_Occupation" class="form-label h6">Occupation</label>
            <input type="text" class="form-control" id="MRP_Occupation" name="MRP_Occupation" value="{{  }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MRP_relationship" class="form-label h6">Relationship</label>
            <input type="text" class="form-control" id="MRP_relationship" name="MRP_relationship" value="{{  }}" readonly>
        </div>
        <div class="col-md-12">
            <label for="MRP_OfficeAdd" class="form-label h6">Work/Home Address</label>
            <input type="text" class="form-control" id="MRP_OfficeAdd" name="MRP_OfficeAdd" value="{{  }}" readonly>
        </div>
        
        
        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>

        <h5>Please click the box if one of the following is applicable to you</h5>

        <!--Family and Social History-->
        <div class="mx-auto row row-cols-lg-2 row-cols-md-1"><!-- START DIV FOR FAMILY HISTORY AND PSH -->
            <div class="col-lg-7 col-md-12 p-2 border border-dark border-lg-end-0">
                <h5>Family History</h5>
                <div class="d-flex flex-row checkboxes">
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_cancer" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_cancer">
                                    Cancer
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_heartDisease" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_heartDisease">
                                    Heart Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_hypertension" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_hypertension">
                                    Hypertension
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_thyroidDisease" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_thyroidDisease">
                                    Thyroid Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_tuberculosis" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_tuberculosis">
                                    Tuberculosis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_HIV/AIDS" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_tuberculosis">
                                    HIV/AIDS
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_diabetesMelittus" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_diabetesMelittus">
                                    Diabetes Melittus
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_mentalDisorder" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_mentalDisorder">
                                    Mental Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_asthma" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_asthma">
                                    Asthma
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_convulsions" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_convulsions">
                                    Convulsions
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_bleedingDyscrasia" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_bleedingDyscrasia">
                                    Bleeding Dyscrasia
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_bleedingDyscrasia" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_bleedingDyscrasia">
                                    Arthritis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_eyeDisorder" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_eyeDisorder">
                                    Eye Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_skinProblems" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_skinProblems">
                                    Skin Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_kidneyProblems" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_kidneyProblems">
                                    Kidney Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_gastroDisease" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_gastroDisease">
                                    Gastrointestinal Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_gastroDisease" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_gastroDisease">
                                    Hepatitis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV --> 
                </div><!-- END OF ROW of CHECKBOXES DIV -->
            <div class="form-row align-items-center">
                <div class="col p-2">
                    <input class="form-check-input" type="checkbox" id="FHP_others" name="FHP_others" {{  }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="FHP_others" style="display: contents!important;">
                            Others
                        </label>
                            <input type="text" class="form-control input-sm" id="FHP_othersDetails" name="FHP_othersDetails" value="{{  }}" {{  }}>

                            <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                    </div><!-- END OF COL OTHERS DIV -->
                </div><!-- END OF ROW OTHERS DIV -->
            </div><!-- END OF COL FH -->

            <!-- START OF PSH -->
            <div class="col-lg-5 col-md-12 p-2 border border-dark">
                <h6>Personal Social History</h6>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="PPSH_smoking" name="PPSH_smoking" {{  }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="PPSH_smoking" style="display: contents!important;">
                            Smoking
                            <br>
                            ( <input type="text" class="col-md-2" id="PPSH_smoking_amount" name="PPSH_smoking_amount" value="{{ $patient->medicalRecord->personalSocialHistory->sticksPerDay }}" {{ $patient->medicalRecord->personalSocialHistory->sticksPerDay == 0 ? 'disabled' : 'readonly' }}> 
                            sticks/day for 
                            <input type="text" class="col-md-2"  id="PPSH_smoking_freq" name="PPSH_smoking_freq" value="{{ $patient->medicalRecord->personalSocialHistory->years }}" {{ $patient->medicalRecord->personalSocialHistory->years == 0 ? 'disabled' : 'readonly' }}> 
                            year/s ) 
                        </label>
                </div><!-- END OF SMOKING FORM DIV -->

                <div class="form-check" style="margin-top:5%;">
                    <input class="form-check-input" type="checkbox" id="PPSH_drinking" name="PPSH_drinking" {{  }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="PPSH_drinking" style="display: contents!important;">
                            Liquor Consumption:
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hospitalization" id="_hospitalization_YES" value="1" required/>
                                <label class="form-check-label" for="hospitalization_YES" style="margin-right: -15px; margin-left:-5px">
                                yes
                                </label>
                            </div><!-- END OF YES DIV -->
                            &nbsp;
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hospitalization" id="hospitalization_NO" value="0"/>
                                <label class="form-check-label" for="hospitalization_NO" style="margin-right: -15px; margin-left:-5px">
                                no
                                </label>
                            </div><!-- END OF NO DIV -->
                            <br>
                           How often?
                            <input type="text" class="col-sm-10" id="hospitalizationDetails" name="hospitalizationDetails" disabled/>
                            <span class="text-danger"> 
                                @error('hospitalizationDetails') 
                                  {{ $message }} 
                                @enderror
                              </span>                   
                        </label>
                </div><!-- END OF DRINKING FORM DIV -->

                    <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->

            </div><!-- END OF PSH COL DIV -->
        </div><!-- END OF ROW ENTIRE DIV -->

        <!--Personal History-->
        
        <h5 class="ms-1">Personal Medical Condition</h5>
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">  
                <div class="d-flex row row-cols-xl-3 row-cols-md-1 justify-content-between">
                    <div class="col-xl-2 p-2">
                        <div class="mx-auto row row-cols-xl-1 row-cols-md-2 row-cols-sm-2 mt-2 ">
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_hypertension" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="PPMC_hypertension">
                                    Hypertension
                                </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_asthma" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_asthma">
                                        Asthma
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" value="1" name="PPMC_diabetes" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_diabetes">
                                        Diabetes
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_arthritis" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_arthritis">
                                        Arthritis
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">                    
                                <input class="form-check-input" type="checkbox" name="PPMC_chickenPox" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_chickenPox">
                                        Chicken Pox
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_dengue" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_dengue">
                                        Dengue
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_tuberculosis" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_tuberculosis">
                                        Tuberculosis
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_pneumonia" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_pneumonia">
                                        Pneumonia
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_covid19" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_covid19">
                                        Covid-19
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_hivAIDS" {{  }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_hivAIDS">
                                        HIV/AIDS
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                        </div>
                    </div>
                <!-- START OF CHECKBOXES WITH INPUT -->
                    <div class="col-xl-5 p-2">
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_hepatitis" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Hepatitis: </span>
                                <input type="text" class="form-control" id="PPMC_hepatitisDetails" name="PPMC_hepatitisDetails" value="{{  }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_thyroidDisorder" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Thyroid Disorder: </span>
                                <input type="text" class="form-control" id="PPMC_thyroidDisorderDetails" name="PPMC_thyroidDisorderDetails" value="{{  }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PPMC_eyeDisorder" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Eye Disorder: </span>
                                <input type="text" class="form-control" id="PMC_eyeDisorderDetails" name="PPMC_eyeDisorderDetails" value="{{  }}" readonly>                                
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_mentalDisorder" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Mental Disorder: </span>
                                <input type="text" class="form-control" id="PPMC_mentalDisorderDetails" name="PPMC_mentalDisorderDetails" value="{{  }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_gastroDisease" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Gastrointestinal Disease: </span>
                                <input type="text" class="form-control" id="PPMC_gastroDiseaseDetails" name="PPMC_gastroDiseaseDetails" value="{{  }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_kidneyDisease" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                 <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Kidney Disease: </span>
                                 <input type="text" class="form-control" id="PPMC_kidneyDiseaseDetails" name="PPMC_kidneyDiseaseDetails" value="{{  }}" readonly>
                             </div>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-xl-5 p-2">
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_heartDisease" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Heart Disease: </span>
                                <input type="text" class="form-control" id="PPMC_heartDiseaseDetails" name="PPMC_heartDiseaseDetails" value="{{  }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_skinDisease" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Skin Disease: </span>
                                <input type="text" class="form-control" id="PPMC_skinDiseaseDetails" name="PPMC_skinDiseaseDetails" value="" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_earDisease" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Ear Disease: </span>
                                <input type="text" class="form-control" id="PPMC_earDiseaseDetails" name="PPMC_earDiseaseDetails" value="{{  }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_cancer" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Cancer: </span>
                                <input type="text" class="form-control" id="PMC_cancerDetails" name="PPMC_cancerDetails" value="{{  }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                            <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_others" style="margin-right: -10px;" {{  }} onclick="this.checked=!this.checked;"/>
                                </div>
                            <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Others: </span>
                                <input type="text" class="form-control" id="PPMC_othersDetails" name="PPMC_othersDetails" value="{{  }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                </div>
            </div>
        </div>
        <!--Medical Status
                    HOSPITALIZATION-->
                    
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">  
                <div class="d-flex flex-row">
                    <div class="col-sm">
                     Do you have history of hospitalization for serious illness, operation, fracture or injury?
                        (<div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="P_hospitalization" id="P_hospitalization_YES" value="1" required/>
                            <label class="form-check-label" for="P_hospitalization_YES" style="margin-right: -15px; margin-left:-5px">
                            yes
                            </label>
                        </div><!-- END OF YES DIV -->
                        &nbsp;
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="P_hospitalization" id="P_hospitalization_NO" value="0"/>
                            <label class="form-check-label" for="P_hospitalization_NO" style="margin-right: -15px; margin-left:-5px">
                            no
                            </label>
                        </div>)<!-- END OF NO DIV -->
                        If yes, please give details:
                        <input type="text" class="col-sm-10" id="P_hospitalizationDetails" name="P_hospitalizationDetails" disabled/>
                        <span class="text-danger"> 
                            @error('P_hospitalizationDetails') 
                              {{ $message }} 
                            @enderror
                          </span>  
                            <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                            <script>
                                $(document).ready(function() {
                                    $('#P_hospitalization_YES, #P_hospitalization_NO').change(function() {
                                        if ($('#P_hospitalization_YES').is(':checked')) {
                                            $('#P_hospitalizationDetails').prop('disabled', false);
                                        } else if ($('#P_hospitalization_NO').is(':checked')) {
                                            $('#P_hospitalizationDetails').prop('disabled', true);
                                        }
                                    });
                                });
                            </script>
                            <!-- END OF SCRIPT --> 
                    </div><!-- END OF COL DIV -->
                </div><!-- END OF ROW DIV -->

                <!-- REGULAR MEDICINES -->
                <div class="d-flex flex-row pt-2">
                    <div class="col-sm">
                        Are you taking any medicine regularly?
                           (<div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="P_regMeds" id="P_regMeds_YES" value="1" required/>
                               <label class="form-check-label" for="P_regMeds_YES" style="margin-right: -15px; margin-left:-5px">
                               yes
                               </label>
                           </div><!-- END OF YES DIV -->
                           &nbsp;
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="P_regMeds" id="P_regMeds_NO" value="0"/>
                               <label class="form-check-label" for="P_regMeds_NO" style="margin-right: -15px; margin-left:-5px">
                               no
                               </label>
                           </div>)<!-- END OF NO DIV -->
                           If yes, name of drug/s:
                           <input type="text" class="col-sm-10" id="P_regMedsDetails" name="P_regMedsDetails" disabled/>
                           <span class="text-danger"> 
                            @error('P_regMedsDetails') 
                              {{ $message }} 
                            @enderror
                          </span>  
                               <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                               <script>
                                   $(document).ready(function() {
                                       $('#P_regMeds_YES, #P_regMeds_NO').change(function() {
                                           if ($('#P_regMeds_YES').is(':checked')) {
                                               $('#P_regMedsDetails').prop('disabled', false);
                                           } else if ($('#P_regMeds_NO').is(':checked')) {
                                               $('#P_regMedsDetails').prop('disabled', true);
                                           }
                                       });
                                   });
                               </script>
                               <!-- END OF SCRIPT --> 
                       </div><!-- END OF COL DIV -->
                   </div><!-- END OF ROW DIV -->

                   <!-- ALLERGIES -->
                   <div class="col-sm" required>
                    Are you allergic to any food or medicine?
                       (<div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="P_allergy" id="P_allergy_YES" value="1" required/>
                           <label class="form-check-label" for="P_allergy_YES" style="margin-right: -15px; margin-left:-5px">
                           yes
                           </label>
                       </div><!-- END OF YES DIV -->
                       &nbsp;
                       <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="P_allergy" id="P_allergy_NO" value="0"/>
                           <label class="form-check-label" for="P_allergy_NO" style="margin-right: -15px; margin-left:-5px">
                           no
                           </label>
                       </div>)<!-- END OF NO DIV -->
                       If yes, specify:
                       <input type="text" class="col-sm-10" id="P_allergyDetails" name="P_allergyDetails" disabled/>
                       <span class="text-danger"> 
                        @error('P_allergyDetails') 
                          {{ $message }} 
                        @enderror
                      </span> 
                           <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                           <script>
                               $(document).ready(function() {
                                   $('#P_allergy_YES, #P_allergy_NO').change(function() {
                                       if ($('#P_allergy_YES').is(':checked')) {
                                           $('#P_allergyDetails').prop('disabled', false);
                                       } else if ($('#P_allergy_NO').is(':checked')) {
                                           $('#P_allergyDetails').prop('disabled', true);
                                       }
                                   });
                               });
                           </script>
                           <!-- END OF SCRIPT --> 
                   </div><!-- END OF COL DIV -->
               </div><!-- END OF ROW DIV -->    

        </div>   
        
        <!--Immunization History-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">
                <h6>Immunization History</h6>
                <div class="my-auto row row-cols-xl-2 row-cols-sm-1 align-items-center" style="margin-left: 5%;">
                    <div class="col-6">
                        <div class="row row-cols-2 row-cols-sm-1 align-items-center">
                            <div class="col-sm-4 p-2">
                                <input type="hidden" name="PIH_bcg" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PIH_bcg">
                                    <label class="form-check-label" for="PIH_bcg" data-toggle="tooltip" data-placement="top" title="Bacille Calmette-Guerin">
                                        BCG
                                    </label>
                            </div>
                            <div class="col-sm-8 p-2">
                                <input type="hidden" name="PIH_polio" value="0">
                                <input class="form-check-input" type="checkbox" value="1"name="PIH_polio">
                                    <label class="form-check-label" for="PIH_polio">
                                        Polio I, II, II, Booster Dose
                                    </label>
                            </div>
                            <div class="col-sm-4 p-2">
                                <input type="hidden" name="PIH_chickenPox" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PIH_chickenPox">
                                    <label class="form-check-label" for="PIH_chickenPox">
                                        Chicken Pox
                                    </label>
                            </div>
                            <div class="col-sm-8 p-2">
                                <input type="hidden" name="IH_dpt" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PIH_dpt">
                                    <label class="form-check-label" for="PIH_dpt">
                                        DPT I, II, III, Booster Dose
                                    </label>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-1 align-items-center">
                            <div class="col-sm-12 p-2">
                                <input type="hidden" name="PIH_covidVacc" value="0">
                                <input class="form-check-input" style="margin-top:6px;" type="checkbox" value="1" id="IH_covidVacc" name="IH_covidVacc">
                                    <label class="form-check-label" for="PIH_covidVacc">
                                        Covid-19 Vaccine I, II
                                    </label>
                                    <input type="text" class="col-sm-2" id="PIH_covidVaccName" name="PIH_covidVaccName" disabled>
                                    <span class="text-danger"> 
                                        @error('PIH_covidVaccName') 
                                        {{  $message }} 
                                        @enderror
                                    </span>
                                    <label class="form-check-label" for="IH_dpt">
                                        Booster I, II
                                    </label>
                                    <input type="text" class="col-sm-2" id="PIH_covidBooster" name="PIH_covidBooster" disabled>
                                        <span class="text-danger"> 
                                            @error('PIH_covidBoosterName') 
                                            {{  $message }} 
                                            @enderror
                                        </span>
                                        <script>
                                            $(document).ready(function() {
                                                $('#PIH_covidVacc').change(function() {
                                                    $('#PIH_covidVaccName').prop('disabled', !this.checked);
                                                    $('#PIH_covidBooster').prop('disabled', !this.checked);
                                                });
                                            });
                                        </script>

                            </div>
                            <div class="col-sm-12 p-2">
                                <input type="hidden" name="PIH_others" value="0">
                                <input class="form-check-input" style="margin-top:6px;" type="checkbox" value="1" id="IH_others" name="IH_others">
                                    <label class="form-check-label" for="PIH_others">
                                        Others
                                    </label>
                                <input type="text" class="col-sm-8" id="PIH_othersDetails" name="PIH_othersDetails" disabled>
                                <span class="text-danger"> 
                                    @error('PIH_othersDetails') 
                                      {{ $message }} 
                                    @enderror
                                 </span> 
                            </div>
                            <script>
                                document.getElementById('PIH_others').onchange = function() {
                                document.getElementById('PIH_othersDetails').disabled = !this.checked;
                                };
                            </script>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-sm-3 align-items-center">
                                <div class="col-4 p-2">
                                    <input type="hidden" name="PIH_typhoid" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_typhoid">
                                        <label class="form-check-label" for="PIH_typhoid">
                                            Typhoid
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="PIH_mumps" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_mumps">
                                        <label class="form-check-label" for="PIH_mumps">
                                            Mumps
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="PIH_hepatitisA" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_hepatitisA">
                                        <label class="form-check-label" for="PIH_hepatitisA">
                                            Hepatitis A
                                        </label>
                                </div>
                                <div class="col-4 p-2">
                                    <input type="hidden" name="PIH_measles" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_measles">
                                        <label class="form-check-label" for="PIH_measles">
                                            Measles
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="PIH_germanMeasles" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_germanMeasles">
                                        <label class="form-check-label" for="PIH_germanMeasles">
                                            German Measles
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="PIH_hepatitisB" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_hepatitisB">
                                        <label class="form-check-label" for="PIH_hepatitisB">
                                            Hepatitis B
                                        </label>
                                </div>
                                <div class="col-4 p-2">
                                    <input type="hidden" name="PIH_measles" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_measles">
                                        <label class="form-check-label" for="PIH_measles">
                                            Pneumoccal
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="PIH_germanMeasles" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_germanMeasles">
                                        <label class="form-check-label" for="PIH_germanMeasles">
                                            Influenza
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="IH_hepatitisB" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_hepatitisB">
                                        <label class="form-check-label" for="PIH_hepatitisB">
                                            HPV
                                        </label>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-1 align-items-center">
                                <div class="col-sm-12 p-2">
                                    <input type="hidden" name="PIH_others" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" id="PIH_others" name="IH_others">
                                        <label class="form-check-label" for="PIH_others">
                                            Others
                                        </label>
                                <input type="text" class="col-sm-9" id="PIH_othersDetails" name="PIH_othersDetails" disabled>
                                        <span class="text-danger"> 
                                            @error('PIH_othersDetails') 
                                            {{ $message }} 
                                            @enderror
                                        </span> 
                                </div>
                            <script>
                                document.getElementById('PIH_others').onchange = function() {
                                document.getElementById('PIH_othersDetails').disabled = !this.checked;
                                };
                            </script>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ATTACHMENTS -->
    <div class="mx-auto row row-cols-lg-1 mt-2">
        <div class="col-md-12 p-2 border border-dark">
            <p class="fs-5 text-center">Please upload a photo of the official reading and result of the following:</p>
            <div class="flex justify-content-center">
                <div class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-1 row-cols-sm-1 my-auto px-5 py-4">
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center" >
                        <label for="MR_chestXray" class="form-label fw-bold">Chest X-Ray Findings</label>
                        <input type="file" class="form-control" id="PMRP_chestXray" name="PMRP_chestXray" accept="image/jpeg, image/png" required>
                    </div>
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_cbcresults" class="form-label fw-bold">CBC Results</label>
                        <input type="file" class="form-control" id="PMRP_cbcresults" name="PMRP_cbcresults" accept="image/jpeg, image/png" required>
                      </div>                      
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_hepaBscreening" class="form-label fw-bold">Hepatitis B Screening</label>
                        <input type="file" class="form-control" id="PMRP_hepaBscreening" name="PMRP_hepaBscreening" accept="image/jpeg, image/png" required>
                    </div> 
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_bloodtype" class="form-label fw-bold">Blood Type</label>
                        <input type="file" class="form-control" id="PMRP_bloodtype" name="PMRP_bloodtype" accept="image/jpeg, image/png" required>
                    </div>
                </div>
                    <div id="resultsContainer" class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-1 row-cols-sm-1 my-auto px-5 py-4">
                        <script>
                            let maxResults = 8;
                            let currentResults = 0;
                            let nextResultId = 1;
                            let lastRemovedResultId = null;
                        
                            const addResult = () => {
                                if (currentResults < maxResults) {
                                    if (lastRemovedResultId !== null) {
                                        nextResultId = lastRemovedResultId;
                                        lastRemovedResultId = null;
                                    } else {
                                        nextResultId = currentResults + 1;
                                    }
                        
                                    let container = document.getElementById('resultsContainer');
                                    let resultDiv = document.createElement('div');
                                    resultDiv.id = `result${nextResultId}`;
                                    resultDiv.classList.add('mb-3', 'col-3', 'd-flex', 'flex-column', 'justify-content-center', 'align-items-center');
                                    resultDiv.innerHTML = `
                                        <div class="align-items-center" style="display: flex; flex-direction: row;">
                                            <label for="MRP_additionalResult${nextResultId}" class="form-label fw-bold me-5" style="margin-right: 20px;">
                                                Results for:
                                            </label>
                                            <button type="button" class="btn btn-sm btn-light ms-5" style="margin-bottom: 5px; "margin-left: 200px;" onclick="removeResult('${nextResultId}')">&times;</button>
                                        </div>
                                        <input type="text" class="form-control my-1" id="MRP_additionalResult${nextResultId}" name="MRP_additionalResult${nextResultId}" placeholder="e.g. Urinalisys, Diabetes, ECG">
                                        <input type="file" class="form-control my-1" id="MRP_additionalUpload${nextResultId}" name="MRP_additionalUpload${nextResultId}" accept="image/jpeg, image/png" required>
                                    `;
                                    container.appendChild(resultDiv);
                                    currentResults++;
                        
                                    if (currentResults == maxResults) {
                                        document.getElementById('addResultButton').disabled = true;
                                    }
                                }
                            }
                        
                            const removeResult = (resultId) => {
                                let resultDiv = document.getElementById(`result${resultId}`);
                                resultDiv.remove();
                                currentResults--;
                                console.log(currentResults);
                                console.log(maxResults);
                        
                                if (currentResults < maxResults) {
                                    document.getElementById('addResultButton').disabled = false;
                                }
                        
                                if (resultId < nextResultId) {
                                    lastRemovedResultId = resultId;
                                }
                            }
                        </script>
                    </div>
                </div>
            <button type="button" id="addResultButton" class="btn btn-primary" onclick="addResult()">Add Result</button>
        </div>
    </div>
    <div class="row no-gutters justify-content-end pt-3 position-relative">
        <div class="col d-flex justify-content-end" style="margin-right:-1  %;">
            <button type="button" class="btn btn-lg btn-primary btn-login fw-bold mb-2" data-bs-toggle="modal" data-bs-target="#submitModal">
                Submit
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modal-xl fade" id="submitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitModalLabel">
                        Medical Form Submission
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <p class="fs-5 fw-bold text-center">Please review your responses carefully before submitting this medical form. </p>
                        <hr>
                        <p class="fs-5 text-center">By submitting this medical form, you are confirming that all the answers provided are true and correct to the best of your knowledge.</p>
                    </div>
                    <div class="modal-footer align-items-center mb-3">
                        <div class="d-flex align-items-center my-auto mx-auto">
                            <div class="input-group">
                                <label for="passwordInput" class="form-label h6 mt-2 me-2">Password:</label>
                                <input type="password" class="form-control" id="passwordInput" name="passwordInput" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <div style="margin-top: -5px;">
                                        <span class="bi bi-eye-fill" aria-hidden="true"></span>
                                    </div>
                                </button>
                            </div>
                        </div>
                        
                        <script>
                            const passwordInput = document.getElementById('passwordInput');
                            const togglePassword = document.getElementById('togglePassword');
                            togglePassword.addEventListener('click', function() {
                                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                passwordInput.setAttribute('type', type);
                                togglePassword.querySelector('span').classList.toggle('bi-eye-fill');
                                togglePassword.querySelector('span').classList.toggle('bi-eye-slash-fill');
                                togglePassword.classList.toggle('active');
                            });
                        </script>
                        <div class="col d-flex justify-content-end align-items-center" style="margin-right:-1  %;">
                            <button class="btn btn-primary btn-login fw-bold" type="submit">Submit</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
        
    </div> 
    <script>
        $(document).ready(function() {
            $('input[type=checkbox]').change(function() {
                var input = $(this).closest('.input-group').find('input[type=text]');
                input.prop('disabled', !this.checked);
            });
        });
    </script>
    <!-- AJAX to prevent refresh -->
    <script>
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault(); // prevent default form submission behavior
            const password = document.getElementById('passwordInput').value;
            const url = '/check-password'; // replace with the URL that checks the password
            const xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // password is correct, submit the form
                        document.getElementById('myForm').submit();
                    } else {
                        // password is incorrect, display an error message
                        alert('Incorrect password');
                    }
                }
            };
            xhr.send(JSON.stringify({ password }));
        });

    </script>
    
</form>
@endsection