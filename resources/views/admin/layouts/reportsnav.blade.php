@extends('admin.layouts.app')

@section('reportsNavContent')

<div class="col-md-12 p-3 text-decoration-none">    
    <div class="btn-group col-md-12" role="group" aria-label="Reports radio button group">
      <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio1" autocomplete="off" onclick="redirectToPatientMedFormList()" checked>
      <label class="btn btn-outline-primary" for="btnradio1">HEALTH RECORDS</label>

      <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio2" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio2">MEDICAL PATIENT RECORDS</label>
    
      <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio3" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio3">DAILY CONSULTATIONS</label>
    
      <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio4" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio4">REPORTS</label>
    </div>
</div>

<script>
  function redirectToPatientMedFormList() {
      window.location.href = "{{ route('admin.patientMedFormList.show') }}";
  }
</script>

@endsection