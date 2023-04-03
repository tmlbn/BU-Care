<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Records</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!--style-->
    <link rel="stylesheet" href="/css/app.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="dist/jquery.tabledit.js"></script>
    <script type="text/javascript" src="custom_table_edit.js"></script>

</head>
<style>
    body{
        background-color: gray;
    }   
</style>    
<body>
    
    <div class="container my-2 bg-light w-55 text-dark p-4">
        <div class="row g-3 pt-5">

            <div class="d-flex justify-content-center">  
                <div class="col-md-9 border border-dark">
                    <header class="text-center">
                        <h1 class="pt-1">MEDICAL PATIENT RECORD</h1>
                    </header>    
                </div>
            </div>

            <div class="container pt-5">
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <label for="select1" class="form-label">Campus</label>
                        <select id="select1" class="form-select">
                            <option> </option>
                            <option>College of Agriculture and Forestry</option>
                            <option>College of Arts and Letters</option>
                            <option>College of Business, Entrepreneurship, and Management</option>
                            <option>College of Education</option>
                            <option>College of Engineering</option>
                            <option>College of Industrial Technology</option>
                            <option>College of Medicine</option>
                            <option>College of Nursing</option>
                            <option>College of Science</option>
                            <option>College of Social Science and Philosophy</option>
                            <option>Institute of Design and Architecture</option>
                            <option>Institute of Physical Education, Sports, and Recreation</option>
                            <option>Gubat Campus</option>
                            <option>Polangui Campus</option>
                            <option>Tabaco Campus</option>
                        </select>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <label for="validationDefault" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="validationDefault" required>
                    </div>
                </div>
            </div> 
            
            <div class="d-flex flex-row">
            </div>
                <div class="col-md-3">
                    <label for="validationDefault01" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="validationDefault01" required>
                </div>
                <div class="col-md-3">
                    <label for="validationDefault02" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="validationDefault02" required>
                </div>
                <div class="col-md-3">
                    <label for="validationDefault03" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="validationDefault03" required>
                </div>
                <div class="col-md-3">
                    <label for="validationDefault04" class="form-label">Birthday</label>
                    <input type="date" class="form-control" id="validationDefault04" required>
                </div>
                <h5>Address</h5>
                <div class="col-md-2">
                    <label for="validationDefault05" class="form-label">No.</label>
                    <input type="text" class="form-control" id="validationDefault05" required>
                </div>
                <div class="col-md-3">
                    <label for="validationDefault05" class="form-label">Street</label>
                    <input type="text" class="form-control" id="validationDefault05" required>
                </div>
                <div class="col-md-3">
                    <label for="validationDefault05" class="form-label">Municipality/City</label>
                    <input type="text" class="form-control" id="validationDefault05" required>
                </div>
                <div class="col-md-2">
                    <label for="select6" class="form-label">Province</label>
                    <select id="select" class="form-select">
                        <option> </option>
                        <option>Abra</option>
                        <option>Agusan del Norte</option>
                        <option>Agusan del Sur</option>
                        <option>Aklan</option>
                        <option>Albay</option>
                        <option>Antique</option>
                        <option>Apayao</option>
                        <option>Aurora</option>
                        <option>Basilan</option>
                        <option>Bataan</option>
                        <option>Batanes</option>
                        <option>Batangas</option>
                        <option>Benguet</option>
                        <option>Biliran</option>
                        <option>Bohol</option>
                        <option>Bukidnon</option>
                        <option>Bulacan</option>
                        <option>Cagayan</option>
                        <option>Camarines Norte</option>
                        <option>Camarines Sur</option>
                        <option>Camiguin</option>
                        <option>Capiz</option>
                        <option>Catanduanes</option>
                        <option>Cavite</option>
                        <option>Cebu</option>
                        <option>Cotabato</option>
                        <option>Davao de Oro (Compostela Valley)</option>
                        <option>Davao del Norte</option>
                        <option>Davao del Sur</option>
                        <option>Davao Occidental</option>
                        <option>Davao Oriental</option>
                        <option>Dinagat Islands</option>
                        <option>Eastern Samar</option>
                        <option>Guimaras</option>
                        <option>Ifugao</option>
                        <option>Ilocos Norte</option>
                        <option>Ilocos Sur</option>
                        <option>Iloilo</option>
                        <option>Isabela</option>
                        <option>Kalinga</option>
                        <option>La Union</option>
                        <option>Laguna</option>
                        <option>Lanao del Norte</option>
                        <option>Lanao del Sur</option>
                        <option>Leyte</option>
                        <option>Maguindanao del Norte</option>
                        <option>Maguindanao del Sur</option>
                        <option>Marindugue</option>
                        <option>Masbate</option>
                        <option>Misamis Occidental</option>
                        <option>Misamis Oriental</option>
                        <option>Northern Samar</option>
                        <option>Nueva Ecija</option>
                        <option>Nueva Vizcaya</option>
                        <option>Occidental Mindoro</option>
                        <option>Oriental Mindoro</option>
                        <option>Palawan</option>
                        <option>Pampanga</option>
                        <option>Pangasinan</option>
                        <option>Quezon</option>
                        <option>Quirino</option>
                        <option>Rizal</option>
                        <option>Romblon</option>
                        <option>Samar</option>
                        <option>Sarangani</option>
                        <option>Siquijor</option>
                        <option>Sorsogon</option>
                        <option>South Cotabato</option>
                        <option>Souther Leyte</option>
                        <option>Sultan Kudarat</option>
                        <option>Sulu</option>
                        <option>Surigao del Norte</option>
                        <option>Surigao del Sur</option>
                        <option>Tarlac</option>
                        <option>Tawi-Tawi</option>
                        <option>Zambales</option>
                        <option>Zamboanga del Norte</option>
                        <option>Zamboanga del Sur</option>
                        <option>Zamboanga Sibugay</option>


                    </select>
                </div>
                <div class="col-md-2">
                    <label for="select6" class="form-label">Religion</label>
                    <select id="select" class="form-select">
                        <option> </option>
                        <option>Roman Catholic</option>
                        <option>Islam</option>
                        <option>Iglesia ni Cristo</option>
                        <option>Evangelicals</option>
                        <option>Protestant</option>
                        <option>Seventh-day Adventist</option>
                        <option>Baptist</option>
                        <option>Jehovah Witness</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="validationDefault07" class="form-label">Contact Number(s)</label>
                    <input type="text" class="form-control" id="validationDefault07" required>
                </div>
                <div class="col-md-3">
                    <label for="select5" class="form-label">Civil Status</label>
                    <select id="select" class="form-select">
                        <option> </option>
                        <option>Single</option>
                        <option>Married</option>
                        <option>Widowed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="select4" class="form-label">Sex</label>
                    <select id="select" class="form-select">
                        <option> </option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="validationDefault08" class="form-label">Age</label>
                    <input type="text" class="form-control" id="validationDefault08" required>
                </div>
                <h5>Parents</h5>
                <div class="col-md-4">
                    <label for="validationDefault09" class="form-label">Father Name</label>
                    <input type="text" class="form-control" id="validationDefault09" required>
                </div>
                <div class="col-md-4">
                    <label for="validationDefault10" class="form-label">Office Address</label>
                    <input type="text" class="form-control" id="validationDefault10" required>
                </div>
                <div class="col-md-4">
                    <label for="validationDefault11" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="validationDefault11" required>
                </div>
                <div class="col-md-4">
                    <label for="validationDefault12" class="form-label">Mother Name</label>
                    <input type="text" class="form-control" id="validationDefault12" required>
                </div>
                <div class="col-md-4">
                    <label for="validationDefault13" class="form-label">Office Address</label>
                    <input type="text" class="form-control" id="validationDefault13" required>
                </div>
                <div class="col-md-4">
                    <label for="validationDefault14" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="validationDefault14" required>
                </div>
                <h5>Incase of Emergency please notify</h5>
                <div class="col-md-6">
                    <label for="validationDefault15" class="form-label">Name</label>
                    <input type="text" class="form-control" id="validationDefault15" required>
                </div>
                <div class="col-md-6">
                    <label for="validationDefault16" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="validationDefault16" required>
                </div>

            <h5>Illness</h5>    

                <!--Illness-->
              <div class="d-flex justify-content-center">  
                <div class="col-md-9 p-2">
                    
                <!--Column 1-->    

                    <div class="d-flex flex-row">
                        <div class="col-md-4 p-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Hypertension
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Diabetes
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Kidney Disease
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Measles
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Diphteria
                                    </label>
                            </div>
                            <div class="col-md-9">
                                <label for="validationDefault17" class="form-label">Others(specify)</label>
                                <input type="text" class="form-control form-control-sm" id="validationDefault17" required>
                            </div>
                        </div>    
                    
                        <!--Column 2-->
                    
                        <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Asthma
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Rheumatic Fever
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Seizure Disorder
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Hepatitis
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Allergy <input type="text" class="form-control form-control-sm">
                                </label>
                        </div>
                    </div> 
                    
                    <!--Column 3--> 

                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Mumps
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Cardiac Disease
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Chicken Pox
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Tuberculosis
                                </label>
                        </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="col-md-12 border border-dark">
        <header class="text-center">
            <h3 class="pt-2">EXAMINATIONS</h3>
        </header>    
    </div>    
    <div class="table">
        <table id="data_table" class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Temperature/Blood Pressure</th>
                    <th>Weight</th>
                    <th>Height</th>
                    <th>History and Physical Examination</th>
                    <th>Physician Directions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                </tr>
            </tbody>
            </table>
            <!-- NEED INPUT FOR ACTUAL CONSULTATION -->
    </div>

</body>
</html>