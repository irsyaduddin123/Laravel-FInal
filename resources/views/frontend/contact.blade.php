@extends('layouts.app')
@section('title', 'Contact - GearGeek Hub')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Message Terkirim',
                text: '{{ session('success')}}',
                icon: 'success',
            });
        </script>
    @endif

    <div class="container contact-section pt-5">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="contact-card rzw-card rzw-row">
              <h1 class="text-center rzw-title">Contact Information</h1>
              <div class="contact-item">
                <i class="fas fa-phone"></i> <span>+628 5122 5147 65</span>
              </div>
              <div class="contact-item">
                <i class="fas fa-envelope"></i> <span>gyulianti@gmail.co.id</span>
              </div>
              <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i> <span>Jl. RE. Martadinata No. 201 Cihapit Bandung Wetan Bandung Jawa Barat</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    <div class="container contact-section">
        <div class="card rzw-card rzw-row">
          <div class="row no-gutters">
            <div class="col-md-6">
              <div class="map-container" style="margin: 40px 0 0 40px">
                <iframe 
                    class="mx-auto"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d11195.03495229081!2d112.72727729961198!3d-7.235985143409579!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sid!4v1715001683967!5m2!1sen!2sid"
                    frameborder="0" 
                    style="border:0;" 
                    allowfullscreen=""
                    width="100%"
                    height="100%"
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card-body contact-form">
                <h1 class="card-title text-center pb-3 rzw-title">Send Us a Message</h1>
                <form action="{{ route('massage.store') }}" method="POST">
                    @csrf
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kamu" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Kamu" required>
                  </div>
                  <div class="form-group">
                    <label for="message">Pesan</label>
                    <textarea class="form-control" id="pesan" name="pesan" rows="5" placeholder="Masukan Pesan Kamu" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
