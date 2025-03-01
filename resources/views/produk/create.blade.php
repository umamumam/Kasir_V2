@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Produk</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="col-xl">
        <div class="card mb-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Produk Baru</h5>
                <small class="text-body float-end">Form Input Produk</small>
            </div>
            <div class="card-body">
                <form action="{{ route('produk.store') }}" method="POST">
                    @csrf
                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-name" class="input-group-text">
                            <i class="ri-price-tag-3-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Produk"
                            value="{{ old('nama') }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-kode" class="input-group-text">
                            <i class="ri-barcode-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Produk"
                            value="{{ old('kode') }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-harga-beli" class="input-group-text">
                            <i class="ri-money-dollar-circle-line ri-20px"></i>
                        </span>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                            placeholder="Harga Beli" value="{{ old('harga_beli') }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-harga-jual" class="input-group-text">
                            <i class="ri-money-dollar-circle-line ri-20px"></i>
                        </span>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                            placeholder="Harga Jual" value="{{ old('harga_jual') }}" required>
                    </div>

                    <div class="input-group input-group-merge mb-6">
                        <span id="basic-icon-default-stok" class="input-group-text">
                            <i class="ri-stack-line ri-20px"></i>
                        </span>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok"
                            value="{{ old('stok') }}" required>
                    </div>

                    <!-- Input Kategori dan Dropdown -->
                    <div class="input-group input-group-merge mb-6" style="position: relative;">
                        <span id="basic-icon-default-kategori" class="input-group-text">
                            <i class="ri-price-tag-3-line ri-20px"></i>
                        </span>
                        <input type="text" class="form-control" id="kategori_input" name="kategori_input" 
                            placeholder="Masukkan Kategori" oninput="filterKategori()" autocomplete="off"
                            value="{{ old('kategori_input') }}" style="border-right: 1px solid #ced4da;">
                        
                        <input type="hidden" name="kategori_id" id="kategori_id">
                        
                        <!-- Opsi Pilihan Kategori -->
                        <ul id="kategori_list" class="dropdown-menu show" 
                            style="width: 100%; display: none; position: absolute; top: 100%; left: 0; z-index: 10; 
                            max-height: 200px; overflow-y: auto; border-radius: 5px; padding: 5px; 
                            border: 1px solid #ced4da; background: white;">
                            @foreach($kategoris as $kategori)
                                <li class="kategori_item">
                                    <a href="javascript:void(0);" class="dropdown-item" 
                                        onclick="pilihKategori('{{ $kategori->id }}', '{{ $kategori->nama }}')">
                                        {{ $kategori->nama }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // function filterKategori() {
    //     const input = document.getElementById('kategori_input').value.toLowerCase();
    //     const select = document.getElementById('kategori_select');
    //     const options = select.getElementsByTagName('option');

    //     for (let i = 0; i < options.length; i++) {
    //         const option = options[i];
    //         const text = option.textContent.toLowerCase();
    //         if (text.includes(input)) {
    //             option.style.display = ''; 
    //         } else {
    //             option.style.display = 'none';
    //         }
    //     }
    // }
    function filterKategori() {
    let input = document.getElementById("kategori_input").value.toLowerCase();
    let list = document.getElementById("kategori_list");
    let items = document.querySelectorAll(".kategori_item");

    let visibleCount = 0;
    for (let item of items) {
        let text = item.textContent.toLowerCase();
        if (text.includes(input) && visibleCount < 5) {
            item.style.display = "block";
            visibleCount++;
        } else {
            item.style.display = "none";
        }
    }

    list.style.display = visibleCount > 0 ? "block" : "none";
}

function pilihKategori(id, nama) {
    document.getElementById("kategori_input").value = nama;
    document.getElementById("kategori_id").value = id;
    document.getElementById("kategori_list").style.display = "none";
}

// Sembunyikan dropdown jika klik di luar
document.addEventListener("click", function(event) {
    let list = document.getElementById("kategori_list");
    let input = document.getElementById("kategori_input");

    if (!input.contains(event.target) && !list.contains(event.target)) {
        list.style.display = "none";
    }
});

</script>

@endsection
