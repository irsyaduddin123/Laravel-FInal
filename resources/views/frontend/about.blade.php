@extends('layouts.app')
@section('style')
<style>
.btn-get-started {
      font-family: "Raleway", sans-serif;
      font-weight: 500;
      font-size: 14px;
      letter-spacing: 1px;
      display: inline-block;
      padding: 12px 32px;
      border-radius: 50px;
      transition: 0.5s;
      line-height: 1;
      margin: 10px;
      color: #fff;
      animation-delay: 0.8s;
      border: 2px solid #ef6603;
    }

    .carousel-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
      position: relative;
      height: 65vh;
    }

    .h2-title {
      color: white;
      margin-bottom: 30px;
      font-size: 40px;
      font-weight: 700;
    }

    .sub-p {
      animation-delay: 0.4s;
      margin: 0 auto 30px auto;
      color: white;
    }

    a {
      text-decoration : none;
    }

    .btn-get-started:hover {
      background: #ef6603;
      color: #fff;
      text-decoration: none;
    }

    .hero-waves {
      width: 100%;
      height: 60px;
      margin-top: 55vh
    }

    .wave1 use {
      animation: move-forever1 10s linear infinite;
      animation-delay: -2s;
    }

    .wave2 use {
      animation: move-forever2 8s linear infinite;
      animation-delay: -2s;
    }

    .wave3 use {
      animation: move-forever3 6s linear infinite;
      animation-delay: -2s;
    }

    .about {
      padding-top: 150px;
      max-width: 100%;
      max-height: 100%;
    }


    .section-title p {
      font-family: "Poppins", sans-serif;
      font-weight: 700;
      font-size: 36px;
    }

    .deskripsi-web {
      text-align: justify;
    }

    .team-text {
      height: 100px;
      overflow: hidden;
    }

    .team-item .team-text {
      position: relative;
      height: 100px;
      overflow: hidden;
    }

    .team-item .team-title {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: #ffffff;
      transition: .5s;
      font-family: Arial, Helvetica, sans-serif;
    }

    .team-item:hover .team-title {
      top: -100px;
    }

    .team-item .team-social {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 100px;
      left: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--primary);
      transition: .5s;
    }

    .team-item .team-social .btn {
      margin: 0 3px;
    }

    .team-item:hover .team-social {
      top: 0;
    }

    @keyframes move-forever1 {
      0% {
        transform: translate(85px, 0%);
      }

      100% {
        transform: translate(-90px, 0%);
      }
    }

    @keyframes move-forever2 {
      0% {
        transform: translate(-90px, 0%);
      }

      100% {
        transform: translate(85px, 0%);
      }
    }

    @keyframes move-forever3 {
      0% {
        transform: translate(-90px, 0%);
      }

      100% {
        transform: translate(85px, 0%);
      }
    }
</style>
@endsection

@section('title','About - GearGeek Hub')

@section('content')
    <div class=" text-center fade-in">
      <div class="container carousel carousel-fade">
          <div class="carousel-item  active ">
              <div class="carousel-container">
                <img src="{{ asset('assets/img/2.png') }}" class="" style="width:100%" alt="geargeekhub">
                <p class="sub-p">Find your stuff here.</p>
                <a href="#about" class="btn-get-started">Read More</a>
              </div>
          </div>
      </div>
    </div>

    <div class="mt-5 pt-5 fade-in">
        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
          <defs>
              <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
          </defs>
          <g class="wave1">
              <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
          </g>
          <g class="wave2">
              <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
          </g>
          <g class="wave3">
              <use xlink:href="#wave-path" x="50" y="9" fill="rgba(26,26,26)">
          </g>
          </svg>
    </div>

    <div id="about" class="container text-white about fade-in">
      <div class="section-title">
        <p>GearGeek Hub</p>
      </div>
      <div class="row contents">
        <div class="col-lg-6">
            <p class="deskripsi-web">
            GearGeekHub adalah platform daring yang menyediakan beragam perlengkapan gaming bagi para pecinta game di seluruh dunia. Dengan fokus pada kualitas dan inovasi, kami menghadirkan koleksi lengkap dari mouse, keyboard, headset, hingga aksesoris gaming lainnya. Dengan pengalaman belanja yang mudah dan aman, GearGeekHub berkomitmen untuk memenuhi kebutuhan gaming Anda dengan produk-produk terbaik di pasaran.
            </p>
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0">
            <p class="deskripsi-web">
            Kami percaya bahwa setiap gamer berhak mendapatkan perlengkapan gaming berkualitas tanpa harus merogoh kocek terlalu dalam. GearGeekHub hadir dengan misi untuk menyediakan produk-produk gaming terbaik dengan harga yang bersaing. Dari merek terkemuka hingga produk-produk unggulan, kami selalu menawarkan harga yang transparan dan terjangkau, sehingga Anda dapat merasakan pengalaman gaming yang optimal tanpa harus mengorbankan kualitas.
            </p>
        </div>
      </div>
    </div>

    <div class="section-title text-white py-5 text-center">
        <p>Our Team</p>
    </div>

    <div class="row justify-content-center pb-5">
        <div class="col-lg-2 col-md-6">
            <div class="team-item text-center">
              <div class="rzw-image-container">
                <img class="img-fluid" src="{{ asset('assets/anggota/abdul_fatah.png') }}" st alt="">
              </div>
                <div class="team-text">
                    <div class="team-title">
                        <br>
                        <h5 style="font-size: 18px;">Abdul Fatah</h5>
                        <br>
                    </div>
                    <div class="team-social">
                        <span style="color: white;">Universitas Indrapasta PGRI</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <div class="team-item text-center">
              <div class="rzw-image-container">
                <img class="img-fluid" src="{{ asset('assets/anggota/ahmad_jazim.png') }}" alt="">
              </div>
                <div class="team-text">
                    <div class="team-title">
                        <h5 style="font-size: 18px;">Ahmad Jazim Irsyaduddin</h5>
                    </div>
                    <div class="team-social">
                        <span style="color: white;">Universitas Dinamika</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <div class="team-item text-center">
              <div class="rzw-image-container">
                <img class="img-fluid" src="{{ asset('assets/anggota/candra.jpg') }}" alt="">
              </div>
                <div class="team-text">
                    <div class="team-title">
                        <h5 style="font-size: 18px;">Candra Setiawan</h5>
                    </div>
                    <div class="team-social">
                        <span style="color: white;">Universitas Kuningan</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <div class="team-item text-center">
              <div class="rzw-image-container">
                <img class="img-fluid" src="{{ asset('assets/anggota/rozir.png') }}" alt="">
              </div>
                <div class="team-text">
                    <div class="team-title">
                        <h5 style="font-size: 18px;">Rozir Wobari</h5>
                    </div>
                    <div class="team-social">
                        <span style="color: white;">Universitas Komputer Indonesia</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <div class="team-item text-center">
              <div class="rzw-image-container">
                <img class="img-fluid" src="{{ asset('assets/anggota/safina.jpg') }}" alt="">
              </div>
                <div class="team-text">
                    <div class="team-title">
                        <h5 style="font-size: 18px;">Safina Faradilla Hasibuan</h5>
                    </div>
                    <div class="team-social">
                        <span style="color: white;">Universitas Mercu Buana</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
