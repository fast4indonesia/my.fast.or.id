<div class="row">

	<div class="col-md-2">
		<a class="btn btn-custom btn-white {{ $cek_menu == 'Peserta' ? 'actives' : ''}}" href="{{$base_url}}cmc/cmc/">Peserta</a>
	</div>
    @if($role == "karyawan")
	<div class="col-md-2">
		<a class="btn btn-custom btn-white {{ $cek_menu == 'Pelaksanaan' ? 'actives' : ''}}" href="{{$base_url}}cmc/cmc/pelaksanaan">Pelaksanaan</a>
	</div>
	@endif
<!-- 	<div class="col-md-2">
		<a class="btn btn-custom btn-white {{ $cek_menu == 'Grafik' ? 'actives' : ''}}" href="{{$base_url.$uri_1}}/{{$controller_name}}/grafik">Grafik</a>
	</div> -->
<!-- 	<div class="col-md-2">
		<a class="btn btn-custom btn-white {{ $cek_menu == 'Terjadwal' ? 'actives' : ''}}" href="{{$base_url}}cmc/cmc/">Terjadwal</a>
	</div>
	<div class="col-md-2">
		<a class="btn btn-custom btn-white {{ $cek_menu == 'Insidental' ? 'actives' : ''}}" href="{{$base_url.$uri_1}}/{{$controller_name}}/insidental">Insidental</a>
	</div>
	<div class="col-md-2">
		<a class="btn btn-custom btn-white {{ $cek_menu == 'Grafik' ? 'actives' : ''}}" href="{{$base_url.$uri_1}}/{{$controller_name}}/grafik">Grafik</a>
	</div> -->
</div>