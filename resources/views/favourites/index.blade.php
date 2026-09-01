@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>My Favourite Listings</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
    </div>
    @if($listings->count()>0)
        <div class="listings-grid">
            @foreach($listings as $listing)
                <div class="listing-card">
                    @if($listing->cover_image)
                        <img src="{{asset('storage/'. $listing->cover_image)}}" alt="{{$listing->title}}">
                    @else
                        <div class="listing-card-placeholder">No image yet.</div>
                    @endif

                    <div class="listing-card-body">
                        <h3>{{$listing->title}}</h3>
                        <p class="listing-location"> {{$listing->country}}, {{$listing->city}}</p>
                        <p class="listing-price">€ {{number_format($listing->price_per_night,2)}}/ night</p>

                        <div class="listing-actions">
                            <a href="{{route('listings.show',$listing)}}" class="btn btn-secondary">View</a>

                            <form action="{{route('favourites.toggle',$listing)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination-container">
            {{$listings->links()}}
        </div>
    @else
        <p class="empty-listings-text">
            You haven't added any listings to your favourites yet. <a href="{{route('listings.index')}}">Explore listings!</a>
        </p>
    @endif

@endsection
