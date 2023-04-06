<!doctype html>
<html>
  <head>
    <!--Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>User List</title>
  </head>

  <body>
    <div class="container pt-3">
      <div class="row">
        <div class="col-md-12">
          @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
              {{Session::get('success')}}
            </div>
          @endif
        </div>
        <div class="col-md-12">
          <form class="row g-3" action="{{route('import_user')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-auto">
              <label class="visually-hidden">Excel</label>
              <input type="file" class="form-control" name="csv_file">
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-primary mb">Upload CSV file</button>
            </div>
            @error('csv_file')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </form>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <h3>User List</h3>
        </div>
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th scope=col>User ID</th>
                <th scope=col>Last Name</th>
                <th scope=col>First Name</th>
                <th scope=col>Town</th>
                <th scope=col>Province</th>
                <th scope=col>School</th>
                <th scope=col>BirthMonth</th>
                <th scope=col>BirthDate</th>
                <th scope=col>BirthYear</th>
              </tr>
            </thead>
            <tbody>
              @if(count($lists))
              @foreach($lists as $list)
               <tr>
                 <th scope="row">{{$list->ApplicantIDNumber}}</th>
                 <th>{{$list->LastName}}</th>
                 <th>{{$list->FirstName}}</th>
                 <th>{{$list->Town}}</th>
                 <th>{{$list->Province}}</th>
                 <th>{{$list->School}}</th>
                 <th>{{$list->BirthMonth}}</th>
                 <th>{{$list->BirthDate}}</th>
                 <th>{{$list->BirthYear}}</th>
              </tr>
             @endforeach
             @else
              <tr>
                <td colspan="3">No data found</td>
              </tr>
             @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
