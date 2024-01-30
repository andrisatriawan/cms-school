<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengaduan</title>
</head>

<body>
    <h1>Pengaduan {{ $data->jenis }}</h1>
    <h4>Detail Pelapor :</h4>
    <table>
        <tr>
            <td style="width: 150px">Nama</td>
            <td style="width: 300px">: {{ $data->nama }}</td>
        </tr>
        <tr>
            <td style="width: 150px">No HP</td>
            <td style="width: 300px">: {{ $data->no_hp }}</td>
        </tr>
        <tr>
            <td style="width: 150px">Email</td>
            <td style="width: 300px">: {{ $data->email }}</td>
        </tr>
    </table>
    <br>
    <h4>Isi aduan :</h4>
    <p>{{ $data->isi_pengaduan }}</p>
</body>

</html>
