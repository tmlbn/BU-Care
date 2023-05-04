@extends('admin.layouts.app')

@section('content')
@if(session('MedicalRecordSuccess'))
        <script>
          $(document).ready(function(){
              $('#successModal').modal("show");
          });          
        </script>
            <div class="modal fade modal-lg" id="successModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fw-bold">BU-Care</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-center">
                        <div class="alert alert-success fade show d-flex align-items-center justify-content-center" style="height:70px;" role="alert">
                          <svg class="bi flex-shrink-0 me-2" fill="#61ff61" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#check-circle-fill"/></svg>
                          <div class="text-center mt-3">
                            <p class="alert-heading fs-5 p-2">Your medical record was successfully submitted!</p>
                          </div>
                        </div>
                          
                        <p class="fs-5">Release Medical Ceriticate?</p>
                      </div>
                      <div class="modal-footer">
                        @if(session('userTicketID'))
                          <button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('releaseMedCertFromAppointment').submit();">
                            Yes
                          </button>
                          <form id="releaseMedCertFromAppointment" action="{{ route('admin.releaseMedCertFromAppointment', ['userTicketID' => session('userTicketID')]) }}" method="POST" class="d-none">
                              @csrf
                          </form>
                        @endif
                        @if(session('patientID'))
                          <button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('releaseMedCert').submit();">
                            Yes
                          </button>
                          <form id="releaseMedCert" action="{{ route('admin.releaseMedCert', ['patientID' => session('patientID')]) }}" method="POST" class="d-none">
                              @csrf
                          </form>
                        @endif
                      </div>
                  </div>
                </div>
            </div>
        @endif
<div class="d-flex bg-cover p-5 p-md-16 p-lg-28 pillars-bg">
    <div class="d-flex flex-column text-white mx-auto pillars-bg-content" style="max-width: 100rem;">
        <img class="" src="{{ asset('media/BU-CareText.png') }}" style="width: 20%;"></h1>
        <div class="col-md-4 border-bottom border-white border-4">
            <span>&nbsp;</span>
        </div>        
        <div class="d-flex flex-column text-white mt-5">
            <h1 class="text-uppercase text-responsive fw-bold fs-3vw fs-md-5vw">Bicol University Health Services</h1>
            <p class="text-xl mt-2 md:mt-4 font-weight-normal text-responsive">Main Campus</p>
        </div>
    </div>
</div>

  <section class="text-gray-600 body-font mt-5 mb-5">
    <div class="container mx-auto d-flex px-5 py-24 flex-lg-row flex-column align-items-center">
      <div class="col-lg-6 col-md-12 mb-10 mb-md-0 clearfix">
        <img class="img-fluid rounded" alt="hero" src="{{ asset('media/clinic.jpg') }}">
      </div>
  
      <div class="col-lg-6 col-md-12 flex-grow-1 d-flex flex-column ms-4">
        <p class="mb-4 lead">With the University Health Clinic stations situated in the Main Campus, the University effectively ensures the provision of quick and competent health care at any time. While it strived to gain this certification to ensure that our patients have peace of mind during their clinic visit. MyHealth’s value of compassionate care translates to initiatives such as this to provide constant reassurance that, aside from health, the safety and security of our people and patients matter.</p>
      </div>
    </div>
  </section>

<!-- Second -->
<div class="bg-light">
  <section class="text-gray-600 body-font">
    <div class="container px-5 py-5 mx-auto">
      <div class="row mb-5 flex-column justify-content-center align-items-center">

        <!-- BUTTONS FOR IMPORT -->
        <div>
          <form action="{{ route('import.store.new') }}" method="post" enctype="multipart/form-data">
            @csrf
            <button type="button" class="btn btn-primary mb-1" onclick="document.getElementById('csv_new').click()">Choose File</button>
              <input type="file" name="csv_new" id="csv_new" accept=".csv" style="display: none" onchange="document.getElementById('file-name-new').textContent = this.files[0].name; document.getElementById('import-btn-new').style.display = this.files.length ? 'inline-block' : 'none'">
              <span id="file-name-new"></span>
            <button id="import-btn-new" class="btn btn-success mb-1" style="display: none">Import New Students</button>
          </form>
        </div>
        <div>
          <form action="{{ route('import.store.old') }}" method="post" enctype="multipart/form-data">
            @csrf
            <button type="button" class="btn btn-primary mb-1" onclick="document.getElementById('csv_old').click()">Choose File</button>
              <input type="file" name="csv_old" id="csv_old" accept=".csv" style="display: none" onchange="document.getElementById('file-name-old').textContent = this.files[0].name; document.getElementById('import-btn-old').style.display = this.files.length ? 'inline-block' : 'none'">
              <span id="file-name-old"></span>
            <button id="import-btn-old" class="btn btn-success mb-1" style="display: none">Import Old Students</button>
          </form>
        </div>
        <div>
          <form action="{{ route('import.store.personnel') }}" method="post" enctype="multipart/form-data">
            @csrf
            <button type="button" class="btn btn-primary mb-1" onclick="document.getElementById('csv_personnel').click()">Choose File</button>
              <input type="file" name="csv_personnel" id="csv_personnel" accept=".csv" style="display: none" onchange="document.getElementById('file-name-personnel').textContent = this.files[0].name; document.getElementById('import-btn-personnel').style.display = this.files.length ? 'inline-block' : 'none'">
              <span id="file-name-personnel"></span>
            <button id="import-btn-personnel" class="btn btn-success mb-1" style="display: none">Import Personnel</button>
          </form>
        </div>

        
        <p class="sm-text-3xl text-2xl font-medium title-font fs-2 mb-2 text-center">Health Services Offered</h1>
        <p class="col-lg-12 col-12 text-center leading-relaxed text-muted">Providing accessible and comprehensive healthcare for all students, faculty, and staff.</p>
      </div>
    <div class="container">
      <div class="row row-cols-1 row-cols-xl-2 g-4">
          <div class="col-lg-6 col-md-12 col-sm-12 p-3">
            <div class="border border-secondary p-4 rounded-lg">
              <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                  <img src="{{ asset('media/png/medical.png') }}" alt="Medical Icon" style="height:50px;">
              </div>
                  <h2 class="h5 text-gray-900 font-weight-medium mb-2">Medical</h2>
                  <p class="mb-0 text-base">We provide comprehensive medical services using the latest technologies and techniques to diagnose, evaluate, and treat various illnesses and conditions. We offer the highest level of care and attention to our patients.</p>
            </div>
          </div>
      
          <div class="col-lg-6 col-md-12 col-sm-10 p-3">
            <div class="border border-secondary p-4 rounded-lg">
              <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                  <img src="{{ asset('media/png/doctor.png') }}" alt="Doctor Icon" style="height:50px;">
              </div>
                  <h2 class="h5 text-gray-900 font-weight-medium mb-2">Qualified Doctors</h2>
                  <p class="mb-0 text-base">Our doctors have years of experience and training to handle various medical conditions and illnesses. They stay up-to-date with the latest advancements to provide you with the best care possible.</p>
            </div>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-xl-2 g-4">
          <div class="col-lg-6 col-md-12 col-sm-10 p-3">
            <div class="border border-secondary p-4 rounded-lg">
              <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                  <img src="{{ asset('media/png/emergency.png') }}" alt="Emergency Icon" style="height:50px;">
              </div>
                  <h2 class="h5 text-gray-900 font-weight-medium mb-2">Emergency Care</h2>
                  <p class="mb-0 text-base">Our emergency care services provide immediate medical attention to patients with urgent care needs. Our experienced team is equipped with state-of-the-art medical equipment to handle a range of emergencies, available for 8 hours a day.</p>
            </div>
          </div>
      
          <div class="col-lg-6 col-md-12 col-sm-10 p-3">
            <div class="border border-secondary p-4 rounded-lg">
              <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                  <img src="{{ asset('media/png/checkup.png') }}" alt="Checkup Icon" style="height:50px;">
              </div>
                  <h2 class="h5 text-gray-900 font-weight-medium mb-2">Checkup</h2>
                  <p class="mb-0 text-base">Our check-up services detect potential health issues early on and help maintain good health. We offer comprehensive health screenings and health plans for to your unique needs and goals. Regular check-ups are essential for optimal well-being.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<!-- third -->
<section class="text-dark body-font">
    <div class="container px-5 py-24 mx-auto d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <div class="col-lg-6 col-12 mb-10 lg:mb-0 rounded-lg" style="margin-right: 4%; margin-left: -7%;">
        <img alt="feature" src="{{ asset('media/suc-pres.png') }}" style="width:130%;">
      </div>

      <div class="col-lg-6 col-12 lg:py-6 lg:pl-12 text-center text-lg-start">
        <div class="d-flex flex-column mb-10 align-items-start">
         <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3 ms-5">Description</h2>
            <p class="leading-relaxed ms-5"></p>
          </div>
        </div>

      <div class="col-lg-6 col-12 lg:py-6 lg:pl-12 text-center text-lg-start">
        <div class="d-flex flex-column mb-10 align-items-start">
          <div class="w-12 h-12 d-inline-flex align-items-center justify-content-center rounded-full bg-blue-100 text-blue-500 mb-5">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
              <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
          </div>
          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3 ms-5">Description</h2>
            <p class="leading-relaxed ms-5"></p>
          </div>
        </div>

      <div class="col-lg-6 col-12 lg:py-6 lg:pl-12 text-center text-lg-start">
        <div class="d-flex flex-column mb-10 align-items-start">
          <div class="w-12 h-12 d-inline-flex align-items-center justify-content-center rounded-full bg-blue-100 text-blue-500 mb-5">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
              <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
          </div>
          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3 ms-5">Description</h2>
            <p class="leading-relaxed ms-5"></p>
          </div>
        </div>

      <div class="col-lg-6 col-12 lg:py-6 lg:pl-12 text-center text-lg-start">
        <div class="d-flex flex-column mb-10 align-items-start">
          <div class="w-12 h-12 d-inline-flex align-items-center justify-content-center rounded-full bg-blue-100 text-blue-500 mb-5">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
              <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
          </div>
          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3 ms-5">Description</h2>
            <p class="leading-relaxed ms-5"></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  
<!-- Fourth -->

<section class="text-dark body-font mt-5">
    <div class="container px-5 py-20 mx-auto">
        <div class="d-flex flex-column text-center w-100 mb-20">
            <h1 class="text-2xl font-medium mb-4 text-dark tracking-widest">Health Service Team</h1>
            <p class="w-lg-50 mx-auto lead">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table. Franzen you probably haven't heard of them.</p>
        </div>
        <div class="row row-cols-1 row-cols-xl-2">
            <div class="col flex flex-wrap">
                <div class="p-4 lg:w-1/2">
                    <div class="h-full flex flex-sm-row flex-col items-center justify-sm-start justify-content-sm-center text-center text-sm-start">
                        <div class="row row-cols-1 row-cols-lg-2">
                            <div class="col">
                                <img alt="team" class="rounded w-100 h-auto mb-sm-0 mb-4" src="{{ asset('media/giga.jpg') }}" style="width:200px;">
                            </div>
                            <div class="col flex-grow pl-sm-8 my-auto">
                                <h2 class="title-font fs-4 text-dark">Nurse1</h2>
                                <h3 class="text-dark mb-3 fs-5">Text</h3>
                                <p class="mb-4">Description</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col flex flex-wrap">
                <div class="p-4 lg:w-1/2">
                    <div class="h-full flex flex-sm-row flex-col items-center justify-sm-start justify-content-sm-center text-center text-sm-start">
                        <div class="row row-cols-1 row-cols-lg-2">
                            <div class="col">
                                <img alt="team" class="rounded w-100 h-auto mb-sm-0 mb-4" src="{{ asset('media/giga1.jpg') }}" style="width:200px;">
                            </div>
                            <div class="col flex-grow pl-sm-8 my-auto">
                                <h2 class="title-font fs-4 text-dark">Nurse2</h2>
                                <h3 class="text-dark mb-3 fs-5">Text</h3>
                                <p class="mb-4">Description</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col flex flex-wrap">
                <div class="p-4 lg:w-1/2">
                    <div class="h-full flex flex-sm-row flex-col items-center justify-sm-start justify-content-sm-center text-center text-sm-start">
                        <div class="row row-cols-1 row-cols-lg-2">
                            <div class="col">
                                <img alt="team" class="rounded w-100 h-auto mb-sm-0 mb-4" src="{{ asset('media/giga2.jpg') }}" style="width:200px;">
                            </div>
                            <div class="col flex-grow pl-sm-8 my-auto">
                                <h2 class="title-font fs-4 text-dark">Nurse3</h2>
                                <h3 class="text-dark mb-3 fs-5">Text</h3>
                                <p class="mb-4">Description</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col flex flex-wrap">
                <div class="p-4 lg:w-1/2">
                    <div class="h-full flex flex-sm-row flex-col items-center justify-sm-start justify-content-sm-center text-center text-sm-start">
                        <div class="row row-cols-1 row-cols-lg-2">
                            <div class="col">
                                <img alt="team" class="rounded w-100 h-auto mb-sm-0 mb-4" src="{{ asset('media/giga3.jpg') }}" style="width:200px;">
                            </div>
                            <div class="col flex-grow pl-sm-8 my-auto">
                                <h2 class="title-font fs-4 text-dark">Nurse4</h2>
                                <h3 class="text-dark mb-3 fs-5">Text</h3>
                                <p class="mb-4">Description</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fifth -->

@endsection