<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Absensi Yatimin</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">
    <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/toggle.css') }}">
    <style>
        .disabled {
            opacity: 0.5;
            pointer-events: none;
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="/"><img src="assets/images/logo/logo.png" alt="Logo"
                                    srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item active">
                            <a href="/" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>Data Presensi</h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal">
                    Tambah Data
                </button>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body py-4-5 px-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon green">
                                                    <i class="iconly-boldProfile"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Sudah Absen</h6>
                                                <h6 class="mb-0 font-extrabold">{{ $sdhAbsen }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body py-4-5 px-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon red">
                                                    <i class="iconly-boldProfile"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Belum Absen</h6>
                                                <h6 class="mb-0 font-extrabold">{{ $blmAbsen }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="section">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table-striped table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Induk</th>
                                                <th>Nama Yatimin</th>
                                                <th>Kelahiran</th>
                                                <th>Alamat</th>
                                                <th>Foto</th>
                                                <th>Tombol</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $pengguna)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pengguna->no_induk }}</td>
                                                    <td>{{ $pengguna->nama_yatimin }}</td>
                                                    <td>{{ $pengguna->kelahiran }}</td>
                                                    <td>{{ $pengguna->alamat }}</td>
                                                    <td>
                                                        @if ($pengguna->foto)
                                                            <img src="{{ asset('storage/photos/' . $pengguna->foto) }}"
                                                                alt="Foto" width="50">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary presensi-btn"
                                                            data-toggle="modal"
                                                            data-target="#webcamModal_{{ $pengguna->id }}"
                                                            data-user-id="{{ $pengguna->id }}"
                                                            data-user-name="{{ $pengguna->nama_yatimin }}"
                                                            {{ $pengguna->status ? '' : 'disabled' }}>
                                                            Presensi
                                                        </button>
                                                    </td>
                                                    <td class="mx-auto">
                                                        <div class="tmbl-tggl">
                                                            <input type="checkbox" class="tggl-btn"
                                                                data-user-id="{{ $pengguna->id }}"
                                                                {{ $pengguna->status ? 'checked' : '' }}>
                                                            <label class="onbtn"><i
                                                                    class="fa-solid fa-check"></i></label>
                                                            <label class="offbtn"><i
                                                                    class="fa-solid fa-xmark"></i></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </section>

                    </div>

                </section>
            </div>

            <footer>
                <div class="footer clearfix text-muted mb-0">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal untuk Tambah -->
    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">Tambah Data Yatimin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addYatimin" action="{{ route('store-yatimin') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="no_induk">No Induk</label>
                            <input type="number" class="form-control" id="no_induk" name="no_induk" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_yatimin">Nama Yatimin</label>
                            <input type="text" class="form-control" id="nama_yatimin" name="nama_yatimin"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="kelahiran">Kelahiran (Tahun)</label>
                            <input type="number" class="form-control" id="kelahiran" name="kelahiran"
                                min="1900" max="{{ date('Y') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($data as $pengguna)
        <!-- Modal untuk Webcam -->
        <div class="modal fade" id="webcamModal_{{ $pengguna->id }}" tabindex="-1" role="dialog"
            aria-labelledby="webcamModalLabel_{{ $pengguna->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <div id="my_camera_{{ $pengguna->id }}"></div>
                            <div id="results_{{ $pengguna->id }}"></div>
                            <div class="d-flex justify-content-center align-items-center mt-4 gap-5">
                                <button type="button" class="btn btn-primary mr-2"
                                    onclick="takeSnapshot({{ $pengguna->id }})">Ambil Gambar</button>
                                <select id="cameraSelect_{{ $pengguna->id }}" class="form-control camera-select mb-2"
                                    style="width: auto; max-width: 150px;">
                                    <option value="" disabled selected>Pilih Kamera</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="closeWebcam({{ $pengguna->id }})">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach





    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script src="assets/js/pages/dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.tggl-btn').change(function() {
                var userId = $(this).data('user-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: '/update-status',
                    type: 'POST',
                    data: {
                        user_id: userId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Status berhasil diperbarui!');
                            location.reload();
                        } else {
                            alert('Terjadi kesalahan.');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $('#addDataModal').on('hidden.bs.modal', function() {
            $('#addYatimin')[0].reset();
        });

        $(document).ready(function() {
            $('#addYatimin').on('submit', function(event) {
                event.preventDefault();
                var form = $(this);
                form.find('button[type="submit"]').prop('disabled', true);

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            title: 'Success',
                            text: response.success,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function(field, messages) {
                            messages.forEach(function(message) {
                                errorMessage += message + '<br>';
                            });
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessage
                        });

                        form.find('button[type="submit"]').prop('disabled', false);
                    }
                });
            });
        });
    </script>

    <script>
        let videoDevices = [];
        let currentDeviceId = null;

        navigator.mediaDevices.enumerateDevices().then((devices) => {
            videoDevices = devices.filter(device => device.kind === 'videoinput');

            if (videoDevices.length > 0) {
                videoDevices.forEach((device, index) => {
                    const option =
                        `<option value="${device.deviceId}">${device.label || `Kamera ${index + 1}`}</option>`;
                    $('.camera-select').append(option);
                });

                const frontCamera = videoDevices.find(device => device.label.toLowerCase().includes('front'));
                currentDeviceId = frontCamera ? frontCamera.deviceId : videoDevices[0].deviceId;
            } else {
                alert("Tidak ada perangkat kamera yang terdeteksi.");
            }
        }).catch((err) => {
            console.error("Error enumerating devices:", err);
            alert("Tidak dapat mengakses kamera. Pastikan browser memiliki izin untuk menggunakan kamera.");
        });

        $(document).on('click', '.presensi-btn', function() {
            var userId = $(this).data('user-id');
            var userName = $(this).data('user-name');

            $('#cameraSelect_' + userId).val(currentDeviceId);

            openWebcam(userId);
        });

        $(document).on('change', '.camera-select', function() {
            const userId = $(this).data('user-id');
            const selectedDeviceId = $(this).val();

            if (selectedDeviceId && selectedDeviceId !== currentDeviceId) {
                currentDeviceId = selectedDeviceId;
                startWebcam(selectedDeviceId, userId);
            }
        });

        $(document).on('hidden.bs.modal', '.modal', function() {
            var userId = $(this).data('user-id');
            closeWebcam(userId);
        });

        function openWebcam(userId) {
            startWebcam(currentDeviceId, userId);
        }

        function startWebcam(deviceId, userId) {
            Webcam.reset();
            Webcam.set({
                width: 1000,
                height: 600,
                image_format: 'jpeg',
                jpeg_quality: 90,
                constraints: {
                    deviceId: {
                        exact: deviceId
                    }
                }
            });

            Webcam.attach(`#my_camera_${userId}`);
        }

        function takeSnapshot(userId) {
            Webcam.snap(function(data_uri) {
                const cameraDiv = document.getElementById('my_camera_' + userId);
                const resultDiv = document.getElementById('results_' + userId);

                resultDiv.innerHTML = '<img src="' + data_uri + '" class="img-fluid"/>';

                cameraDiv.style.display = "none";
                resultDiv.style.display = "block";

                $.ajax({
                    url: '/save-photo',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        photo: data_uri
                    },
                    success: function(response) {
                        alert('Foto berhasil disimpan');
                        location.reload();
                    },
                    error: function() {
                        alert('Gagal menyimpan foto');
                    }
                });
            });
        }

        function closeWebcam(userId) {
            Webcam.reset(`#my_camera_${userId}`);

            var resultsElement = document.getElementById('results_' + userId);
            if (resultsElement) {
                resultsElement.innerHTML = "";
            }
        }
    </script>





    <script src="assets/js/main.js"></script>
</body>

</html>
