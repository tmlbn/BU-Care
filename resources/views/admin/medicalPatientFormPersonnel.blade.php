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
                                <label class="form-check-label" for="FHP_HIV/AIDS">
                                    HIV/AIDS
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_diabetesMelittus" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_diabetesMelittus">
                                    Diabetes Mellittus
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
                            <input class="form-check-input" type="checkbox" name="FHP_Arthritis" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_Arthritis">
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
                            <input class="form-check-input" type="checkbox" name="FHP_Hepatitis" {{  }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_Hepatitis">
                                    Hepatitis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV --> 
                </div><!-- END OF ROW of CHECKBOXES DIV -->
            <div class="form-row align-items-center">
                <div class="col p-2">
                    <input class="form-check-input" type="checkbox" id="FHP_others" name="FHP_others" {{  }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="FHP_others" style="display: contents!important;">
                            OthersFHP_othersDetails
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
                            <input class="form-check-input" type="radio" name="P_hospitalization" id="P_hospitalization_YES" onclick="return false;/>
                            <label class="form-check-label" for="P_hospitalization_YES" style="margin-right: -15px; margin-left:-5px">
                            yes
                            </label>
                        </div><!-- END OF YES DIV -->
                        &nbsp;
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="P_hospitalization" id="P_hospitalization_NO" onclick="return false;"/>
                            <label class="form-check-label" for="P_hospitalization_NO" style="margin-right: -15px; margin-left:-5px">
                            no
                            </label>
                            <script>
                                if ({{ $patient->medicalRecord->hospitalization }} == 1) {
                                    document.getElementById("hospitalization_YES").checked = true;
                                } else {
                                    document.getElementById("hospitalization_NO").checked = true;
                                }
                            </script>
                        </div>)<!-- END OF NO DIV -->
                        If yes, please give details:
                        <input type="text" class="col-sm-10" id="P_hospitalizationDetails" name="P_hospitalizationDetails" value="{{  }}" {{  }}>
                            <!-- END OF SCRIPT --> 
                    </div><!-- END OF COL DIV -->
                </div><!-- END OF ROW DIV -->

                <!-- REGULAR MEDICINES -->
                <div class="d-flex flex-row pt-2">
                    <div class="col-sm">
                        Are you taking any medicine regularly?
                           (<div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="P_regMeds" id="P_regMeds_YES" onclick="return false;"/>
                               <label class="form-check-label" for="P_regMeds_YES" style="margin-right: -15px; margin-left:-5px">
                               yes
                               </label>
                           </div><!-- END OF YES DIV -->
                           &nbsp;
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="P_regMeds" id="P_regMeds_NO" onclick="return false;"/>
                               <label class="form-check-label" for="P_regMeds_NO" style="margin-right: -15px; margin-left:-5px">
                               no
                               </label>
                               <script>
                                if ({{ $patient->medicalRecord->hospitalization }} == 1) {
                                    document.getElementById("hospitalization_YES").checked = true;
                                } else {
                                    document.getElementById("hospitalization_NO").checked = true;
                                }
                            </script>
                           </div>)<!-- END OF NO DIV -->
                           If yes, name of drug/s:
                           <input type="text" class="col-sm-10" id="P_regMedsDetails" name="P_regMedsDetails" value="{{  }}" {{  }}>
                               <!-- END OF SCRIPT --> 
                       </div><!-- END OF COL DIV -->
                   </div><!-- END OF ROW DIV -->

                   <!-- ALLERGIES -->
                   <div class="col-sm" required>
                    Are you allergic to any food or medicine?
                       (<div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="P_allergy" id="P_allergy_YES" onclick="return false;"/>
                           <label class="form-check-label" for="P_allergy_YES" style="margin-right: -15px; margin-left:-5px">
                           yes
                           </label>
                       </div><!-- END OF YES DIV -->
                       &nbsp;
                       <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="P_allergy" id="P_allergy_NO" onclick="return false;"/>
                           <label class="form-check-label" for="P_allergy_NO" style="margin-right: -15px; margin-left:-5px">
                           no
                           </label>
                           <script>
                            if ({{ ->hospitalization }} == 1) {
                                document.getElementById("hospitalization_YES").checked = true;
                            } else {
                                document.getElementById("hospitalization_NO").checked = true;
                            }
                        </script>
                       </div>)<!-- END OF NO DIV -->
                       If yes, specify:
                       <input type="text" class="col-sm-10" id="P_allergyDetails" name="P_allergyDetails" value="{{  }}" {{  }}>
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
                                <input class="form-check-input" type="checkbox" name="PIH_bcg" {{  }} onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_bcg" data-toggle="tooltip" data-placement="top" title="Bacille Calmette-Guerin">
                                        BCG
                                    </label>
                            </div>
                            <div class="col-sm-8 p-2">
                                <input class="form-check-input" type="checkbox" name="PIH_polio" onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_polio">
                                        Polio I, II, II, Booster Dose
                                    </label>
                            </div>
                            <div class="col-sm-4 p-2">
                                <input class="form-check-input" type="checkbox" name="PIH_chickenPox" onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_chickenPox">
                                        Chicken Pox
                                    </label>
                            </div>
                            <div class="col-sm-8 p-2">
                                <input class="form-check-input" type="checkbox" name="PIH_dpt" onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_dpt">
                                        DPT I, II, III, Booster Dose
                                    </label>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-1 align-items-center">
                            <div class="col-sm-12 p-2">
                                <input class="form-check-input" style="margin-top:6px;" type="checkbox" id="IH_covidVacc" name="IH_covidVacc" onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_covidVacc">
                                        Covid-19 Vaccine I, II
                                    </label>
                                    <input type="text" class="col-sm-2" id="PIH_covidVaccName" name="PIH_covidVaccName" value="{{  }}">
                                    <label class="form-check-label" for="IH_dpt">
                                        Booster I, II
                                    </label>
                                    <input type="text" class="col-sm-2" id="PIH_covidBooster" name="PIH_covidBooster" value="{{  }}">
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
                                <input class="form-check-input" style="margin-top:6px;" type="checkbox" id="PPIH_others" name="PPIH_others" onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PPIH_others">
                                        Others
                                    </label>
                                <input type="text" class="col-sm-8" id="PPIH_othersDetails" name="PPIH_othersDetails" value="{{  }}">
                            </div>
                            <script>
                                document.getElementById('PPIH_others').onchange = function() {
                                document.getElementById('PPIH_othersDetails').disabled = !this.checked;
                                };
                            </script>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-sm-3 align-items-center">
                                <div class="col-4 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_typhoid" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_typhoid">
                                            Typhoid
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_mumps" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_mumps">
                                            Mumps
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_hepatitisA" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_hepatitisA">
                                            Hepatitis A
                                        </label>
                                </div>
                                <div class="col-4 p-2">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_measles" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_measles">
                                            Measles
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_germanMeasles" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_germanMeasles">
                                            German Measles
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_hepatitisB" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_hepatitisB">
                                            Hepatitis B
                                        </label>
                                </div>
                                <div class="col-4 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_Pneumoccal" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_Pneumoccal">
                                            Pneumoccal
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_Influenza" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_Influenza">
                                            Influenza
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_HPV" onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_HPV">
                                            HPV
                                        </label>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-1 align-items-center">
                                <div class="col-sm-12 p-2">
                                    <input class="form-check-input" type="checkbox" id="PIH_others" name="PIH_others" onclick="this.checked=!this.checked;">
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
                        <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                            <img src="{{ asset('storage/app/'.->medicalRecord->chestXray) }}" alt="Chest X-Ray Findings">
                        </div>
                    </div>
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_cbcresults" class="form-label fw-bold">CBC Results</label>
                        <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                            <img src="{{ asset('storage/app/'.->medicalRecord->CBCResults) }}" alt="CBC Results">
                        </div>
                      </div>                      
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_hepaBscreening" class="form-label fw-bold">Hepatitis B Screening</label>
                        <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                            <img src="{{ asset('storage/app/'.->medicalRecord->hepaBscreening) }}" alt="Hepatitis B Screening">
                        </div>
                    </div> 
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_bloodtype" class="form-label fw-bold">Blood Type</label>
                        <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                            <img src="{{ asset('storage/app/'.->medicalRecord->bloodType) }}" alt="Blood Type">
                        </div>
                    </div>
                </div>

                <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                    <header class="text-center">
                        <!-- LINE BREAK -->
                    </header>
                </section>
                
                <p class="text-center fw-bold pt-1" style="user-select:none;">
                    ---------- TO BE ACCOMPLISHED BY THE MEDICAL PERSONNEL ----------
                </p>
                    
                <!-- START OF PHYSICIAN INPUT -->
                <!-- VITAL SIGNS -->
                <div class="mx-auto row row-cols-lg-1 mt-2">
                    <div class="col-md-12 p-1 border border-dark">
                        <div class="container">
                            <p class="fs-4">VITAL SIGNS:ANTHROPOMETRICS</p>
                            <div class="row row-cols-xl-3 row-cols-sm-1 justify-content-center">
                                <!-- Col 1 (BASELINE) -->
                                <div class="col-xl-3">
                                    <div class="form-group d-flex">
                                        <label for="VS_bloodPressure" class="form-label h6 my-auto me-1" style="white-space: nowrap;">BP:&nbsp;</label>
                                        <div class="d-flex align-items-center ms-4"style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1" id="VS_bp_systolic" name="VS_bp_systolic"  maxlength="3" style="width:31.7%;" required>
                                                <span class="text-danger"> 
                                                    @error('VS_bp_systolic') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                            <span class="fs-6">/</span>
                                            <input type="text" class="form-control ms-2" id="VS_bp_diastolic" name="VS_bp_diastolic" maxlength="3" style="width:31.7%;" required> 
                                            <p class="pt-3" style="margin-left: 4px;">mmHg</p>
                                                <span class="text-danger"> 
                                                    @error('VS_bp_diastolic') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>                   
                                    <div class="form-group d-flex">
                                        <label for="VS_pulseRate" class="form-label h6 my-auto me-1">PR:&nbsp;</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1 ms-4" id="VS_pulseRate" name="VS_pulseRate" maxlength="4" required>
                                            <p class="pt-3" style="margin-left: 4px;">/minute</p>
                                                <span class="text-danger"> 
                                                    @error('VS_pulseRate') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>                 
                                    <div class="form-group d-flex">
                                        <label for="VS_respirationRate" class="form-label h6 my-auto me-1">RR:&nbsp;</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1 ms-4" id="VS_respirationRate" name="VS_respirationRate" maxlength="4" required>
                                            <p class="pt-3" style="margin-left: 4px;">/minute</p>
                                                <span class="text-danger"> 
                                                    @error('VS_respirationRate') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex">
                                        <label for="VS_temp" class="form-label h6 my-auto me-1">Temp:</label>
                                        <div class="d-flex align-items-center">
                                            <input type="text" class="form-control me-1" id="VS_temp" name="VS_temp" maxlength="4" style="margin-left: 1px; width:90%;" required>
                                            <p class="pt-3" style="margin-left: 4px;">°C</p>
                                                <span class="text-danger"> 
                                                    @error('VS_temp') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>
                                </div> 
                                <!-- Col 2 (HEIGHT, WEIGHT, BMI) -->
                                <div class="col-xl-3 mx-4">
                                    <div class="form-group d-flex">
                                        <label for="VS_height" class="form-label h6 my-auto me-1">Height:</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1 ms-1" id="VS_height" name="VS_height" maxlength="4" required>
                                            <p class="pt-3" style="margin-left: 4px;">meters</p>
                                                <span class="text-danger"> 
                                                    @error('VS_height') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>  
                                    <div class="form-group d-flex">
                                        <label for="VS_weight" class="form-label h6 my-auto me-1">Weight:</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1" id="VS_weight" name="VS_weight" maxlength="4" required>
                                            <p class="pt-3" style="margin-left: 4px;">kgs</p>
                                                <span class="text-danger"> 
                                                    @error('VS_weight') 
                                                    {{ $message }} 
                                                     @enderror
                                                </span>
                                        </div>
                                    </div>  
                                    <div class="form-group d-flex">
                                        <label for="VS_bmi" class="form-label h6 my-auto me-1">BMI:&nbsp;</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1 ms-4" id="VS_bmi" name="VS_bmi" maxlength="4" required>
                                            <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                                <span class="text-danger">
                                                    @error('VS_bmi')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Col 3 (FINDINGS) -->
                                <div class="col-xl-5">
                                    <div class="form-group d-flex">
                                        <label for="VS_xrayFindings" class="form-label h6 my-auto me-1" style="white-space: nowrap;">CHEST X-RAY FINDINGS:</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1" id="VS_xrayFindings" name="VS_xrayFindings" maxlength="4" style="width:310px;" required>
                                            <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                                <span class="text-danger"> 
                                                    @error('VS_xrayFindings') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>                   
                                    <div class="form-group d-flex">
                                        <label for="VS_cbcResults" class="form-label h6 my-auto me-1" style="white-space: nowrap;">CBC Results:</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1" id="VS_cbcResults" name="VS_cbcResults" maxlength="4" style="width:310px; margin-left: 86px;" required>
                                            <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                                <span class="text-danger"> 
                                                    @error('VS_cbcResults') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>               
                                    <div class="form-group d-flex">
                                        <label for="VS_hepaBscreening" class="form-label h6 my-auto me-1" style="white-space: nowrap;">Hepatitis B Screening:</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1" id="VS_hepaBscreening" name="VS_hepaBscreening" maxlength="4" style="margin-left: 12px; width:310px;" required>
                                            <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                                <span class="text-danger"> 
                                                    @error('VS_hepaBscreening') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex">
                                        <label for="VS_bloodType" class="form-label h6 my-auto me-1" style="white-space: nowrap;">Blood Type:</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1" id="VS_bloodType" name="VS_bloodType" maxlength="4" style="margin-left: 94px; width:310px;" required>
                                            <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                                <span class="text-danger"> 
                                                    @error('VS_bloodType') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>
                                </div>   
                             </div>
                        </div>
                    </div>
                </div>
</form>
@endsection