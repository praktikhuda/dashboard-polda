@extends('app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <img src="{{ asset('assets/images/small/img-7.jpg') }}" style="object-fit: cover; height: 500px; float:center">

    <div class="row pt-3">
        <!-- Card for Tribrata News -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-light rounded">
                <a href="/polda/tribrata-news/online.html" class="text-decoration-none">
                    <div class="card-body text-center">
                        <i class="bi bi-newspaper" style="font-size: 40px; color: #ff5733;"></i> <!-- Adjusted icon color -->
                        <h3 class="card-title mt-3 text-dark">Tribrata News</h3>
                        <p class="card-text text-muted">Daftar berita terbaru Kepolisian Daerah Istimewa Yogyakarta</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Card for Galeri -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm border-light rounded">
                <a href="/polda/galeri.html" class="text-decoration-none">
                    <div class="card-body text-center">
                        <i class="bi bi-images" style="font-size: 40px; color: #ff5733;"></i> <!-- Adjusted icon color -->
                        <h3 class="card-title mt-3 text-dark">Galeri</h3>
                        <p class="card-text text-muted">Daftar galeri kegiatan Kepolisian Daerah Istimewa Yogyakarta</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Card for Agenda -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm border-light rounded">
                <a href="/polda/agenda.html" class="text-decoration-none">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check-fill" style="font-size: 40px; color: #ff5733;"></i> <!-- Adjusted icon color -->
                        <h3 class="card-title mt-3 text-dark">Agenda</h3>
                        <p class="card-text text-muted">Daftar agenda kegiatan Kepolisian Daerah Istimewa Yogyakarta</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-12 d-block d-lg-none">
        <h3 class="mb-0 polda-css-2">Visi dan Misi KAPOLDA</h3>
        <p class="fst-italic">
            Irjen Pol Suwondo Nainggolan, S.I.K., M.H. </p>
    </div>
    <div class="col-lg-5">
        <img src="https://jogja.polri.go.id/polda/file/sambutan.jpeg" class="img-fluid polda-css-3" alt="">
    </div>
    <div class="col-lg-7 pt-4 pt-lg-0 content">
        <h3 class="d-none d-lg-block mb-0">Visi dan Misi KAPOLDA</h3>
        <p class="fst-italic d-none d-lg-block">
            Irjen Pol Suwondo Nainggolan, S.I.K., M.H. </p>
        <div class="summernote">
            <p>Kepala Kepolisian Daerah Istimewa Yogyakarta mengeluarkan visi yaitu</p>
            <ul>
                <li>Terwujudnya Yogyakarta yang Aman dan tertib<br></li>
            </ul>
            <div><br></div>
            <div>Adapun misi dari Polda Daerah Istimewa Yogyakarta adalah<br></div>
            <ul>
                <li>Melindungi<br></li>
                <li>Mengayomi<br></li>
                <li>Dan melayani masyarakat</li>
            </ul>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>

</script>
@endsection