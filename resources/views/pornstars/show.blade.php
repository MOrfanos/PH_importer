@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Basic Info
                    </div>
                    <div class="card-body">
                        <p class="card-text" id="basic-info-name">Name: {{ $pornstar->id }}</p>
                        <p class="card-text" id="basic-info-id">ID: {{ $pornstar->id }}</p>
                        <p class="card-text" id="basic-info-license">License: {{ $pornstar->license }}</p>
                        <p class="card-text" id="basic-info-link">Link: {{ $pornstar->link }}</p>
                        <p class="card-text" id="basic-info-wlStatus">wlStatus: {{ $pornstar->wlStatus }}</p>
                        <p class="card-text" id="basic-info-aliases">Aliases: {{ $pornstar->aliases ? collect($pornstar->aliases)->implode(', ') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Attributes
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="attributes-list">
                            @foreach($pornstar->attributes->toArray() as $key => $attribute)
                                <li class="list-group-item">
                                    {{ $key }}: {{ $attribute ?? 'N/A' }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Stats
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="stats-list">
                            @foreach($pornstar->stats->toArray() as $key => $stat)
                                <li class="list-group-item">
                                    {{ "$key: $stat" }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Thumbnails
                    </div>
                    <div class="card-body">
                        <div id="thumbnails-container">
                            @foreach($pornstar->cachedThumbnails as $thumbnail)
                                <img src="{{ $thumbnail['url'] }}" height="{{ $thumbnail['height'] }}" width="{{ $thumbnail['width'] }}" data-image_type="{{ $thumbnail['type'] }}" class="img-thumbnail mr-2 mb-2" style="max-width: 100px;">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <button id="backButton" type="button" class="btn btn-secondary">Back</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#backButton').click(function () {
            window.history.back();
        });
    </script>
@endpush
