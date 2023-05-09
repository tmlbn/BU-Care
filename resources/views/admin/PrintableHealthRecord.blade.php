<!DOCTYPE html>
<html>
<head>
	<title>Health Record</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
		}
		h1 {
			font-size: 18px;
			font-weight: bold;
			margin-bottom: 20px;
		}
		table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 20px;
		}
		th, td {
			padding: 5px;
			border: 1px solid #ccc;
			text-align: left;
			vertical-align: top;
		}
		th {
			background-color: #f0f0f0;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<h1>Health Record</h1>
	
	<table>
		<tr>
			<th>Name:</th>
			<td>{{ $patient->name }}</td>
		</tr>
		<tr>
			<th>Date of Birth:</th>
			<td>{{ $patient->date_of_birth }}</td>
		</tr>
		<tr>
			<th>Gender:</th>
			<td>{{ $patient->sex }}</td>
		</tr>
		<tr>
			<th>Blood Type:</th>
			<td>{{ $patient->id }}</td>
		</tr>
	</table>
	
	<h2>Medical History</h2>
	
	<table>
		<tr>
			<th>Date</th>
			<th>Condition</th>
			<th>Treatment</th>
		</tr>
	
	</table>
	
	<h2>Medications</h2>
	
	<table>
		<tr>
			<th>Name</th>
			<th>Dosage</th>
			<th>Schedule</th>
		</tr>

	</table>
</body>
</html>
