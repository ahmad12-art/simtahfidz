@extends('layouts.app')

@section('title', 'Edit Setoran Hafalan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('setoran.index') }}">Setoran Hafalan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<x-page-header title="Edit Setoran Hafalan" />

<x-data-table>
    <form method="POST" action="{{ route('setoran.update', $setoran) }}">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-6"><x-form-input label="Tanggal" name="tanggal" type="date" :value="$setoran->tanggal->format('Y-m-d')" required /></div>
            <div class="col-md-6">
                <x-form-select label="Target Hafalan (opsional)" name="target_hafalan_id">
                    @foreach($target as $t)
                        <option value="{{ $t->id }}" @selected($setoran->target_hafalan_id==$t->id)>{{ $t->santri->nama }} — {{ $t->surah->nama_surah ?? '' }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <x-form-select label="Santri" name="santri_id" required>
                    @foreach($santri as $s)<option value="{{ $s->id }}" @selected($setoran->santri_id==$s->id)>{{ $s->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-4">
                <x-form-select label="Guru Penilai" name="guru_id" required>
                    @foreach($guru as $g)<option value="{{ $g->id }}" @selected($setoran->guru_id==$g->id)>{{ $g->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-4">
                <x-form-select label="Surah" name="surah_id" required>
                    @foreach($surah as $s)<option value="{{ $s->id }}" @selected($setoran->surah_id==$s->id)>{{ $s->nomor_surah }}. {{ $s->nama_surah }}</option>@endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Ayat Awal" name="ayat_awal" type="number" :value="$setoran->ayat_awal" required /></div>
            <div class="col-md-6"><x-form-input label="Ayat Akhir" name="ayat_akhir" type="number" :value="$setoran->ayat_akhir" required /></div>
        </div>

        <hr>
        <h6 class="fw-bold mb-3">Penilaian</h6>
        <div class="row">
            <div class="col-md-3"><x-form-input label="Kelancaran (40%)" name="nilai_kelancaran" type="number" :value="$setoran->nilai_kelancaran" data-nilai-component required /></div>
            <div class="col-md-3"><x-form-input label="Tajwid (30%)" name="nilai_tajwid" type="number" :value="$setoran->nilai_tajwid" data-nilai-component required /></div>
            <div class="col-md-3"><x-form-input label="Makhraj (20%)" name="nilai_makhraj" type="number" :value="$setoran->nilai_makhraj" data-nilai-component required /></div>
            <div class="col-md-3"><x-form-input label="Adab (10%)" name="nilai_adab" type="number" :value="$setoran->nilai_adab" data-nilai-component required /></div>
        </div>

        <div class="alert alert-light border d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small">Perkiraan Nilai Akhir</span>
                <h4 class="mb-0" id="nilai-akhir-preview">{{ $setoran->nilai_akhir }}</h4>
            </div>
            <div class="text-end">
                <span class="text-muted small">Predikat</span>
                <h4 class="mb-0" id="predikat-preview">{{ $setoran->predikat }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Status" name="status" required>
                    @foreach(['lancar','mengulang','belum_lancar'] as $st)
                        <option value="{{ $st }}" @selected($setoran->status===$st)>{{ ucfirst(str_replace('_',' ',$st)) }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>
        <x-form-input label="Catatan" name="catatan" :value="$setoran->catatan" />

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Perbarui</button>
            <a href="{{ route('setoran.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
