@extends(Auth::check() ? 'layouts.app' : 'layouts.LandingLayout')

@section('content')
<div class="flex justify-center  bg-no-repeat bg-cover p-5 md:p-16 lg:p-28" style="background-image:url('media/pillars.jpg')">
  <div class="flex flex-col justify-center  max-w-7xl  text-white">
      <h1 class="text-base font-medium tracking-wider ">Welcome to my Client Template</h1>
       <span class="underline underline-offset-2 text-white -mt-3"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
          &nbsp; </span>
      <div class="flex flex-col text-white mt-5">
          <h1 class="text-4xl md:text-[50px] font-semibold">Bicol University Health Service</h1>
          <p class="text-xl mt-2 md:mt-4 tracking-wide">Main Campus</p>
      </div>
      <p class="mt-4 text-sm md:w-[52%] tracking-wide leading-7">Tailblocks provides best Tailwind CSS
          components. Visit our website and feel free to give feedback. With the help of Tailblocks, a user can
          build a website in a much lesser time.</p>
  </div>
</div> 

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://use.fontawesome.com/03f8a0ebd4.js"></script>

<section class="text-gray-600 body-font">
    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
      <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
        <img class="object-cover object-center rounded" alt="hero" src="{{ asset('media/clinic.jpg') }}">
      </div>

      <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col items-center text-center">
      <p class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900 text-center">Bicol University Health Services
          <br class="hidden lg:inline-block">Main Campus
      </p>
        <p class="mb-8 leading-relaxed">With the University Health Clinic stations situated in the Main Campus, the University 
        effectively ensures the provision of quick and competent health care at any time. While it strived to gain this certification to 
        ensure that our patients have peace of mind during their clinic visit. MyHealth’s value of compassionate care 
        translates to initiatives such as this to provide constant reassurance that, aside from health, the safety and security of our people and patients matter. 
        </p>
      </div>
    </div>    
  </section>

<!-- Second -->
<div class="bg-blue-50">
<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
      <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">Health Service Offers</h1>
        <p class="lg:w-1/2 w-full leading-relaxed text-gray-500">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table.</p>
      </div>

      <div class="flex flex-wrap -m-4">
        <div class="xl:w-1/3 md:w-1/2 p-4">
          <div class="border border-gray-200 p-6 rounded-lg">
            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-4">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
              </svg>
            </div>

            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Medical</h2>
            <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
          </div>
        </div>

        <div class="xl:w-1/3 md:w-1/2 p-4">
          <div class="border border-gray-200 p-6 rounded-lg">
            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-4">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                <circle cx="6" cy="6" r="3"></circle>
                <circle cx="6" cy="18" r="3"></circle>
                <path d="M20 4L8.12 15.88M14.47 14.48L20 20M8.12 8.12L12 12"></path>
              </svg>
            </div>

            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Qualified Doctors</h2>
            <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
          </div>
        </div>
        
        <div class="xl:w-1/3 md:w-1/2 p-4">
          <div class="border border-gray-200 p-6 rounded-lg">
            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-4">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Emergency Care</h2>
            <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
          </div>
        </div>

        <div class="xl:w-1/3 md:w-1/2 p-4">
          <div class="border border-gray-200 p-6 rounded-lg">
            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-4">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1zM4 22v-7"></path>
              </svg>
            </div>
            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Checkup</h2>
            <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
          </div>

        </div>
        <div class="xl:w-1/3 md:w-1/2 p-4">
          <div class="border border-gray-200 p-6 rounded-lg">
            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-4">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
              </svg>
            </div>

            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Bunker</h2>
            <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
          </div>
        </div>

        <div class="xl:w-1/3 md:w-1/2 p-4">
          <div class="border border-gray-200 p-6 rounded-lg">
            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-4">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              </svg>
            </div>
            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Ramona Falls</h2>
            <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waist co, subway tile poke farm.</p>
          </div>
        </div>
      </div>
    </div>
</div>
  </section>

<!-- third -->

<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap items-center text-center">
      <div class="lg:w-1/2 w-full mb-10 lg:mb-0 rounded-lg overflow-hidden">
        <img alt="feature" class="object-cover object-center h-full w-full" src="{{ asset('media/suc-pres.png') }}">
      </div>

      <div class="flex flex-col flex-wrap lg:py-6 -mb-10 lg:w-1/2 lg:pl-12 lg:text-left text-center">
        <div class="flex flex-col mb-10 lg:items-start items-center">
          <div class="w-12 h-12 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
              <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
          </div>

          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Description</h2>
            <p class="leading-relaxed text-base">SOY BOY</p>
          </div>
        </div>

        <div class="flex flex-col mb-10 lg:items-start items-center">
          <div class="w-12 h-12 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
              <circle cx="6" cy="6" r="3"></circle>
              <circle cx="6" cy="18" r="3"></circle>
              <path d="M20 4L8.12 15.88M14.47 14.48L20 20M8.12 8.12L12 12"></path>
            </svg>
          </div>

          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Description</h2>
            <p class="leading-relaxed text-base">SOY BOY</p>
          </div>
        </div>

        <div class="flex flex-col mb-10 lg:items-start items-center">
          <div class="w-12 h-12 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
              <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </div>

          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Description</h2>
            <p class="leading-relaxed text-base">SOY BOY</p>
        </div>

      </div>
    </div>
  </section>

  
<!-- Fourth -->

<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
      <div class="flex flex-col text-center w-full mb-20">
        <h1 class="text-2xl font-medium title-font mb-4 text-gray-900 tracking-widest">Health Service    Team</h1>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table. Franzen you probably haven't heard of them.</p>
      </div>
  
      <div class="flex flex-wrap -m-4">
        <div class="p-4 lg:w-1/2">
          <div class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
            <img alt="team" class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4" src="{{ asset('media/giga.jpg') }}">
            <div class="flex-grow sm:pl-8">
              <h2 class="title-font font-medium text-lg text-gray-900">Nurse1</h2>
              <h3 class="text-gray-500 mb-3">Text</h3>
              <p class="mb-4">Description</p>
  
            </div>
          </div>
        </div>
        <div class="p-4 lg:w-1/2">
          <div class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
            <img alt="team" class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4" src="{{ asset('media/giga1.png') }}">
            <div class="flex-grow sm:pl-8">
              <h2 class="title-font font-medium text-lg text-gray-900">Nurse2</h2>
              <h3 class="text-gray-500 mb-3">Text</h3>
              <p class="mb-4">Description</p>
  
            </div>
          </div>
        </div>
        <div class="p-4 lg:w-1/2">
          <div class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
            <img alt="team" class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4" src="{{ asset('media/giga2.jpg') }}">
            <div class="flex-grow sm:pl-8">
              <h2 class="title-font font-medium text-lg text-gray-900">Nurse3</h2>
              <h3 class="text-gray-500 mb-3">Text</h3>
              <p class="mb-4">Description</p>
  
            </div>
          </div>
        </div>
        <div class="p-4 lg:w-1/2">
          <div class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
            <img alt="team" class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4" src="{{ asset('media/giga3.jpg') }}">
            <div class="flex-grow sm:pl-8">
              <h2 class="title-font font-medium text-lg text-gray-900">Nurse4</h2>
              <h3 class="text-gray-500 mb-3">Text</h3>
              <p class="mb-4">Description</p>
  
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<!-- Fifth -->




@endsection