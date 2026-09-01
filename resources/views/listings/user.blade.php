@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex">
            <h2>My Listings</h2>
            <a href="{{route('listings.create')}}" class="btn">Create Listing</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif

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
                                <a href="{{route('listings.edit',$listing)}}" class="btn btn-warning">Edit</a>

                                <form action="{{route('listings.destroy',$listing)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
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
                You haven't created any listings yet. <a href="{{route('listings.create')}}">Create your first one!</a>
            </p>
        @endif
    </div>
@endsection
