@extends('admin.layouts.app')

@section('content')
<div class="d-flex bg-cover p-5 p-md-16 p-lg-28 pillars-bg">
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
    <div class="container mx-auto d-flex px-5 py-24 flex-lg-row flex-column align-items-center">
        <div class="col-lg-6 col-md-10">
          <img class="img-fluid rounded" alt="Main Campus Clinic" src="{{ asset('media/clinic.jpg') }}">
        </div>
        <div class="col-lg-6 col-md-12 d-flex flex-column ms-4">
          <p class="mb-4 lead lh-base">With the University Health Clinic stations situated in the Main Campus, the University effectively ensures the provision of quick and competent health care at any time. While it strived to gain this certification to ensure that our patients have peace of mind during their clinic visit. MyHealth’s value of compassionate care translates to initiatives such as this to provide constant reassurance that, aside from health, the safety and security of our people and patients matter.</p>
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
                    <p class="mb-0 text-base"> we are committed to providing our patients with comprehensive medical services. Our team of highly qualified medical professionals utilizes the latest medical technologies and techniques to offer a range of diagnostic testing, medical evaluations, and treatments for various illnesses and conditions. Whether you require routine medical care or specialized treatment, we are here to provide you with the highest level of care and attention.</p>
              </div>
            </div>
        
            <div class="col p-3">
              <div class="border border-secondary p-4 rounded-lg">
                <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                    <img src="{{ asset('media/png/doctor.png') }}" alt="Doctor Icon" style="height:50px;">
                </div>
                    <h2 class="h5 text-gray-900 font-weight-medium mb-2">Qualified Doctors</h2>
                    <p class="mb-0 text-base">Our team of qualified doctors is composed of highly experienced medical professionals who are committed to providing you with the best possible care. With years of training and experience in their respective fields, our doctors are equipped to handle a wide range of medical conditions and illnesses. They are dedicated to staying up-to-date with the latest medical advancements and technologies to ensure that you receive the most effective treatments available.</p>
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
                    <p class="mb-0 text-base">Our emergency care services are available 8 hours a day to provide immediate medical attention to patients who require urgent care. Our team of emergency medical professionals is highly trained to handle a wide range of medical emergencies, from minor injuries to life-threatening conditions. Our state-of-the-art emergency department is equipped with the latest medical equipment and technology to provide the best possible care to our patients in their time of need.</p>
              </div>
            </div>
        
            <div class="col p-3">
              <div class="border border-secondary p-4 rounded-lg">
                <div class="w-10 h-10 d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white mb-4">
                    <img src="{{ asset('media/png/checkup.png') }}" alt="Checkup Icon" style="height:50px;">
                </div>
                    <h2 class="h5 text-gray-900 font-weight-medium mb-2">Checkup</h2>
                    <p class="mb-0 text-base">Our check-up services are designed to help you maintain good health and prevent potential health problems. We offer comprehensive health screenings and evaluations to detect any potential health issues early on, when they are easier to treat. Our team of medical professionals will work with you to develop a personalized health plan that fits your unique needs and goals. We believe that regular check-ups are essential for maintaining optimal health and well-being.</p>
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
