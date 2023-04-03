@extends(Auth::check() ? 'layouts.app' : 'layouts.appForUnAuth')

@section('content')


<div class="d-flex bg-cover p-5 p-md-16 p-lg-28" style="background-image:url('media/pillars.jpg'); background-repeat: no-repeat; background-size:100%;">
    <div class="d-flex flex-column text-white mx-auto" style="max-width: 100rem;">
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
    <div class="container mx-auto d-flex px-5 py-24 flex-md-row flex-column align-items-center">
      <div class="col-md-6 mb-10 mb-md-0">
        <img class="img-fluid rounded" alt="hero" src="{{ asset('media/clinic.jpg') }}">
      </div>
  
      <div class="col-lg-6 col-md-6 flex-grow-1 d-flex flex-column ms-4">
        <p class="mb-4 fs-3 fw-medium text-gray-900">Bicol University Health Services<br class="d-none d-lg-inline-block">Main Campus</p>
        <p class="mb-4 lead">With the University Health Clinic stations situated in the Main Campus, the University effectively ensures the provision of quick and competent health care at any time. While it strived to gain this certification to ensure that our patients have peace of mind during their clinic visit. MyHealth’s value of compassionate care translates to initiatives such as this to provide constant reassurance that, aside from health, the safety and security of our people and patients matter.</p>
      </div>
    </div>
  </section>

<!-- Second -->
<div class="bg-light">
    <section class="text-gray-600 body-font">
      <div class="container px-5 py-5 mx-auto">
        <div class="row mb-5 flex-column justify-content-center align-items-center">
          <p class="sm-text-3xl text-2xl font-medium title-font fs-2 mb-2 text-center">Health Services Offered</h1>
          <p class="col-lg-6 col-12 text-center leading-relaxed text-muted">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
            <div class="col p-3">
              <div class="border border-secondary p-4 rounded-lg">
                <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                    <img src="{{ asset('media/png/medical.png') }}" alt="Medical Icon" style="height:50px;">
                </div>
                    <h2 class="h5 text-gray-900 font-weight-medium mb-2">Medical</h2>
                    <p class="mb-0 text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
              </div>
            </div>
        
            <div class="col p-3">
              <div class="border border-secondary p-4 rounded-lg">
                <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                    <img src="{{ asset('media/png/doctor.png') }}" alt="Doctor Icon" style="height:50px;">
                </div>
                    <h2 class="h5 text-gray-900 font-weight-medium mb-2">Qualified Doctors</h2>
                    <p class="mb-0 text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
              </div>
            </div>
          </div>

          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
            <div class="col p-3">
              <div class="border border-secondary p-4 rounded-lg">
                <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                    <img src="{{ asset('media/png/emergency.png') }}" alt="Emergency Icon" style="height:50px;">
                </div>
                    <h2 class="h5 text-gray-900 font-weight-medium mb-2">Emergency Care</h2>
                    <p class="mb-0 text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
              </div>
            </div>
        
            <div class="col p-3">
              <div class="border border-secondary p-4 rounded-lg">
                <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                    <img src="{{ asset('media/png/checkup.png') }}" alt="Checkup Icon" style="height:50px;">
                </div>
                    <h2 class="h5 text-gray-900 font-weight-medium mb-2">Checkup</h2>
                    <p class="mb-0 text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
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
            <p class="leading-relaxed ms-5">SOY BOY</p>
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
            <p class="leading-relaxed ms-5">SOY BOY</p>
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
            <p class="leading-relaxed ms-5">SOY BOY</p>
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
            <p class="leading-relaxed ms-5">SOY BOY</p>
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
