@extends('layouts.app')

@section('content')
    <div class="listing-form-container">
        <h2>Edit Listing</h2>
        <form action="{{route('listings.update',$listing)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title: </label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title',$listing->title)}}" required>
                @error('title')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description: </label>
                <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{old('description',$listing->description)}}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="city">City: </label>
                    <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" value="{{old('city',$listing->city)}}">
                    @error('city')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="country">Country: </label>
                    <input type="text" id="country" name="country" class="form-control @error('country') is-invalid @enderror" value="{{old('country',$listing->country)}}" required>
                    @error('country')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price_per_night">Price per Night (€)</label>
                    <input type="number" step="0.01" id="price_per_night" name="price_per_night" class="form-control @error('price_per_night') is-invalid @enderror" value="{{old('price_per_night',$listing->price_per_night)}}" required>
                    @error('price_per_night')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cover_image">Cover Image: </label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control-file @error('cover_image') is-invalid @enderror" >
                    @error('cover_image')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photos">Upload Photos (Multiple):</label>
                    <input type="file" name="photos[]" id="photos" class="form-control-file @error('photos') is-invalid @enderror" multiple>
                    @error('photos')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    @error('photos.*')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <!--Hidden inputs for coordinates-->
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $listing->latitude) }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $listing->longitude) }}">

            <div class="form-group">
                <label>Pin a Location:</label>
                <div id="create-map"></div>
                @error('latitude')
                    <span class="error-message">Select a latitude</span>
                @enderror

                @error('longitude')
                <span class="error-message">Select a longitude</span>
                @enderror
            </div>
            <button type="submit" class="btn-submit">Update Listing</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const defaultLat = {{ $listing->latitude ?? 37.9838 }};
            const defaultLng = {{ $listing->longitude ?? 23.7275 }};

            const map = L.map('create-map').setView([defaultLat, defaultLng], 14)

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker = L.marker([defaultLat, defaultLng]).addTo(map);

            map.on('click', function (e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }
            });
        });
    </script>
@endsection
