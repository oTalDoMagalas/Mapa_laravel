@extends('layouts.app')

@section('title', 'Editar ' . $location->name . ' - Laravel Maps App')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>
                <div class="fas fa-edit me-2"></div>
                <a href="{{ route('locations.show', $location->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                </a>
            </h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-map me-2"></i></h5>
            </div>
            <div class="card-body">
                <div id="map" style="height: 400px;"></div>
                <div class="mt-3"><small class="text-muted"><i class="fas fa-info-circle me-1"></i> Clique no mapa para selecionar um local.</small></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Editar Local</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('locations.update', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome do Local*</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude*</label>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}" required>
                                @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude*</label>
                                <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" required>
                                @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Endereço</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label @error('category') is-invalid @enderror">Categoria</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Selecione uma categoria</option>
                            <option value="Restaurante" {{ old('category') == 'Restaurante' ? 'selected' : '' }}>Restaurante</option>
                            <option value="Hotel" {{ old('category') == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="Shopping" {{ old('category') == 'Shopping' ? 'selected' : '' }}>Shopping</option>
                            <option value="Parque" {{ old('category') == 'Parque' ? 'selected' : '' }}>Parque</option>
                            <option value="Museu" {{ old('category') == 'Museu' ? 'selected' : '' }}>Museu</option>
                            <option value="Teatro" {{ old('category') == 'Teatro' ? 'selected' : '' }}>Teatro</option>
                            <option value="Hospital" {{ old('category') == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                            <option value="Escola" {{ old('category') == 'Escola' ? 'selected' : '' }}>Escola</option>
                            <option value="Outro" {{ old('category') == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Atualizar Local
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([-23.5505, -46.633], 10); // São Paulo, Brasil

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = null;

        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup(`
            <div class="text-center">
            <strong>Coordenadas selecionadas:</strong><br>
            Lat: ${lat.toFixed(8)}<br>
            Lng: ${lng.toFixed(8)}
            </div>
            `).openPopup();
        });
    });
</script>
@endsection