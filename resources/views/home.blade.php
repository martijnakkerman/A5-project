@extends('layouts.app')

@section('styling')
<style>
    /* Add custom CSS to set a fixed height for the card bodies */
    .card-body {
        overflow: hidden;
        height: 200px; /* Adjust the height as needed */

    }
    /* Set a fixed height and use object-fit for the images */
    .card-img-top {
        height: 300px; /* Adjust the height as needed */
        object-fit: cover; /* Crop larger images while maintaining aspect ratio */
    }
    /* Ensure that text inside the card body is vertically centered */
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .card-link {
        text-decoration: none;
    }

    .card-text {
        text-overflow: ellipsis;
        overflow: hidden;
    }

</style>
@endsection

@section('content')

    <div id="content" class="container">
        <div class="row">
            @forelse($bands as $band)
                <div class="col-md-4">
                    <a href="{{ route('band.details', ['band' => $band->id]) }}" class="card-link">
                        <div class="card mb-4">
                            <img class="card-img-top" src="{{ asset("storage/".$band->image_path) }}" alt="Band Image">
                            <div class="card-body d-flex flex-column justify-content-start">
                                <h4 class="card-title fw-bold">{{ $band->name }}</h4>
                                <p class="card-text">{{ $band->description }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-md-12">
                    <p>No bands found.</p>
                </div>
            @endforelse
        </div>
    </div>


@endsection
